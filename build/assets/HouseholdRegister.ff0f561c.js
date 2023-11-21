import{A,N as U,_ as q,U as M,o as T,f as B}from"./AppLayout.c471b81a.js";import{_ as F}from"./TextInput.86ba2c92.js";import{_ as E}from"./InputLabel.5855d489.js";import{o as r,e as a,a as e,B as _,c as G,w as h,b as l,f as u,F as V,i as S,g as D,t as m,D as j,N as I,n as y}from"./app.c9482037.js";import{_ as R}from"./_plugin-vue_export-helper.cdc0426e.js";import{r as K,a as O,b as Q}from"./MagnifyingGlassIcon.72cf383a.js";import{r as J}from"./CheckCircleIcon.00a0f7b3.js";import{r as W}from"./UserIcon.f957ed43.js";import{l as X}from"./switch.67ed66d7.js";function Y(o,s){return r(),a("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.5",stroke:"currentColor","aria-hidden":"true"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"})])}const Z={components:{AppLayout:A,TextInput:F,InputLabel:E,Dialog:U,DialogPanel:q,DialogTitle:M,TransitionChild:T,TransitionRoot:B,Switch:X,MagnifyingGlassIcon:K,PlusIcon:O,ExclamationTriangleIcon:Q,CreditCardIcon:Y,CheckCircleIcon:J,UserIcon:W},props:["allocated_villages","households","state"],data(){return{display_households:this.households,search_query:"",household_form:{show_popup:!1,popup_title:"Create New Household",is_active:!0,village:{value:"",error:!1},name:{value:"",error:!1},mobile_aadhaar:{value:"",error:!1},social_status:{value:"",error:!1},age:{value:"",error:!1,error_msg:"Please enter household age"},save_type:"new",household_id:null,processing:!1},card_distribution_form:{show_popup:!1,view:"enter_hhid",popup_title:"Card Distribution Form",popup_description:"Enter HH Id to check card distribution",hh_id:{value:"",error:!1,error_msg:"Please enter valid HH ID"},hh_row_id:"",already_distributed:!1,has_distributed:!1,processing:!1},view_household_form:{hh_id:{value:"",error:!1,error_msg:"Please enter valid HH ID"},show_popup:!1,processing:!1},delete_form:{household_name:"",household_id:null,show_popup:!1,processing:!1}}},methods:{search(){var o=this.search_query.toString().toLowerCase();if(o.length>0){this.display_households=[];for(var s in this.households){var d=this.households[s];if(d.name.toString().toLowerCase().includes(o)){this.display_households.push(d);continue}if(d.hh_id.toString().toLowerCase().includes(o)){this.display_households.push(d);continue}if(d.age.toString().toLowerCase().includes(o)){this.display_households.push(d);continue}if(d.village&&d.village.name.toString().toLowerCase().includes(o)){this.display_households.push(d);continue}}}else this.display_households=this.households},cardDistribution(){this.card_distribution_form.popup_title="Card Distribution Form",this.card_distribution_form.popup_description="Enter HH Id to check card distribution",this.card_distribution_form.view="enter_hhid",this.card_distribution_form.already_distributed=!1,this.card_distribution_form.has_distributed=!1,this.card_distribution_form.hh_id.value="",this.card_distribution_form.show_popup=!0},checkCardDistribution(){var o=this.card_distribution_form;o.hh_id.error=!1;var s=o.hh_id.value;if(s.length==0){o.hh_id.error=!0,o.hh_id.error_msg="Please enter valid HH ID";return}o.processing=!0;var d=new FormData;d.append("hh_id",s),axios.post("/household-register/card-distribution",d).then(function(c){o.processing=!1;var t=c.data;t.status==1?t.data.card_distribution==1?o.already_distributed=!0:(o.hh_row_id=t.data.id,o.view="card_distribution_details",o.popup_title=t.data.name,o.popup_description="Check the card distribution status"):(o.hh_id.error=!0,o.hh_id.error_msg=t.error_msg)})},updateCardDistributionStatus(){var o=this.card_distribution_form;o.processing=!0;var s=new FormData;s.append("hh_row_id",o.hh_row_id),s.append("distributed",o.has_distributed?1:0),axios.post("/household-register/card-distribution/update",s).then(function(d){o.processing=!1;var c=d.data;c.status==1?o.show_popup=!1:(o.hh_id.error=!0,o.hh_id.error_msg=c.error_msg)})},viewHousehold(){this.view_household_form.show_popup=!0},viewHouseholdProcess(){var o=this.view_household_form;o.hh_id.error=!1;var s=o.hh_id.value;if(s.length==0){o.hh_id.error=!0,o.hh_id.error_msg="Please enter valid HH ID";return}o.processing=!0;var d=new FormData;d.append("hh_id",s);var c=this;axios.post("/household-register/check-hhid",d).then(function(t){o.processing=!1;var n=t.data;n.status==1?c.$inertia.visit("/household/"+n.data.id):(o.hh_id.error=!0,o.hh_id.error_msg=n.error_msg)})},addHousehold(){this.household_form.village.error=!1,this.household_form.name.error=!1,this.household_form.mobile_aadhaar.error=!1,this.household_form.social_status.error=!1,this.household_form.age.error=!1,this.household_form.age.error_msg="Please enter household age",this.household_form.save_type="new",this.household_form.household_id=null,this.household_form.is_active=!0,this.household_form.popup_title="Create New Household",this.household_form.show_popup=!0},editHousehold(o){this.household_form.village.error=!1,this.household_form.name.error=!1,this.household_form.mobile_aadhaar.error=!1,this.household_form.social_status.error=!1,this.household_form.age.error=!1,this.household_form.age.error_msg="Please enter household age",this.household_form.save_type="edit",this.household_form.household_id=o.id,this.household_form.name.value=o.name,this.household_form.is_active=o.is_active==1,this.household_form.popup_title="Edit Household",this.household_form.show_popup=!0},deleteHousehold(o,s){this.delete_form.household_name=o,this.delete_form.household_id=s,this.delete_form.show_popup=!0},validateForm(){var o=this.household_form;o.village.error=!1,o.name.error=!1,o.mobile_aadhaar.error=!1,o.social_status.error=!1,o.age.error=!1,o.age.error_msg="Please enter household age";var s=o.village.value.toString();if(s.length==0){o.village.error=!0;return}var d=o.name.value.toString();if(d.length==0){o.name.error=!0;return}var c=o.mobile_aadhaar.value.toString();if(c.length!=10&&c.length!=12){o.mobile_aadhaar.error=!0;return}var t=o.social_status.value.toString();if(t.length==0){o.social_status.error=!0;return}var n=o.age.value.toString();if(parseInt(n)<18){o.age.error=!0,o.age.error_msg="Only 18+ age allowed";return}this.saveHousehold(s,d,c,t,n)},saveHousehold(o,s,d,c,t){this.household_form.processing=!0;var n=new FormData;n.append("village_id",o),n.append("name",s),n.append("mobile_aadhaar",d),n.append("social_status",c),n.append("age",t),n.append("state",this.state),n.append("save_type",this.household_form.save_type),n.append("household_id",this.household_form.household_id),n.append("is_active",this.household_form.is_active?1:0);var b=this;axios.post("/household-register/save",n).then(function(x){b.household_form.processing=!1;var v=x.data;v.status==1&&b.$inertia.visit("/household-register",{only:["households"]})})},deleteProcess(){this.delete_form.processing=!0;var o=new FormData;o.append("household_id",this.delete_form.household_id);var s=this;axios.post("/pre-requisites/delete",o).then(function(d){s.delete_form.processing=!1;var c=d.data;c.status==1&&s.$inertia.visit("/pre-requisites",{only:["households"]})})}}},$={class:"flex-1"},ee={class:"border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8"},te=e("div",{class:"min-w-0 flex-1"},[e("h1",{class:"text-base lg:text-lg font-medium leading-6 text-gray-900 sm:truncate"},"Last 10 Households")],-1),se={class:"flex gap-4 mt-0 ml-4"},oe=e("span",{class:"hidden lg:block"},"Card Distribution",-1),ie=e("span",{class:"lg:hidden"},"Card",-1),le=e("span",{class:"hidden lg:block"},"View Household",-1),re=e("span",{class:"lg:hidden"},"Household",-1),ae=e("span",{class:"hidden lg:block"},"New Household",-1),ne=e("span",{class:"lg:hidden"},"New",-1),de={key:0,class:"mt-6 px-4 sm:px-6 lg:px-8"},ue={class:"max-w-sm"},he={class:"relative rounded-md shadow-sm"},ce={class:"pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"},_e={class:"mt-6"},me={key:0,class:"mt-20 inline-block min-w-full align-middle"},fe={class:"flex items-center flex-col"},pe=e("img",{src:"/images/documents.png",class:"w-72",alt:""},null,-1),ge=e("h3",{class:"mt-2 text-lg font-semibold text-gray-900"},"No pre-requisite available",-1),be=e("p",{class:"mt-1 text-sm text-gray-500"},"Get started by creating a new pre-requisite.",-1),ve={class:"mt-6"},ye=e("span",null,"New Household",-1),xe={key:1,class:"inline-block min-w-full border-b border-gray-200 align-middle"},we={class:"min-w-full"},ke=e("thead",null,[e("tr",{class:"border-t border-gray-200"},[e("th",{class:"border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900",scope:"col"},[e("span",{class:"lg:pl-2"},"Name")]),e("th",{class:"hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell",scope:"col"},"Village"),e("th",{class:"hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell",scope:"col"},"Age"),e("th",{class:"border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900",scope:"col"})])],-1),Ce={class:"divide-y divide-gray-100 bg-white"},He={class:"w-1/3 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900"},De={class:"lg:pl-2"},Ve={class:"font-medium text-gray-900"},Se={class:"text-gray-500"},je={class:"hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell"},Ie={key:0},Pe={key:1},Le=e("span",{class:"inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800"},"Deleted",-1),ze=[Le],Ne={class:"hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell"},Ae=e("td",null,null,-1),Ue={key:0},qe=e("td",{colspan:"5",class:"whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900"},[e("span",{class:"lg:pl-2 text-gray-600 font-medium"},"No results found!")],-1),Me=[qe],Te=e("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),Be={class:"fixed inset-0 z-10 overflow-y-auto"},Fe={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},Ee={class:"bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4"},Ge={class:"flex justify-between items-center"},Re=e("div",{class:"mt-1"},[e("p",{class:"text-sm text-gray-500"},"Enter the details of the household head")],-1),Ke={class:"my-5 flex flex-col gap-y-6"},Oe={class:"grid grid-cols-2 gap-5"},Qe={class:""},Je=e("option",{value:"",selected:"",disabled:""},"Select Village",-1),We=["value"],Xe={key:0,class:"mt-1 text-red-600 text-sm"},Ye={class:""},Ze={class:"relative rounded-md shadow-sm"},$e={key:0,class:"mt-1 text-red-600 text-sm"},et={class:"grid grid-cols-2 gap-5"},tt={class:""},st={class:"relative rounded-md shadow-sm"},ot={key:0,class:"pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3"},it={key:0,src:"/images/call.svg",class:"h-5 w-71","aria-hidden":"true"},lt={key:1,src:"/images/aadhaar.svg",class:"h-5 w-71","aria-hidden":"true"},rt={key:0,class:"mt-1 text-red-600 text-sm"},at={class:""},nt=e("option",{value:"",selected:"",disabled:""},"Select Social Status",-1),dt=e("option",{value:"apl"},"APL",-1),ut=e("option",{value:"apl-1"},"APL - 1",-1),ht=e("option",{value:"apl-2"},"APL - 2",-1),ct=e("option",{value:"bpl"},"BPL",-1),_t=e("option",{value:"bpl_antyodaya"},"BPL Antyodaya",-1),mt=[nt,dt,ut,ht,ct,_t],ft={key:0,class:"mt-1 text-red-600 text-sm"},pt={class:"grid grid-cols-2 gap-5"},gt={class:""},bt={class:"relative rounded-md shadow-sm"},vt=e("p",{class:"mt-2 text-xs text-gray-400 font-medium"},"This cannot be modified",-1),yt={class:""},xt={class:"relative rounded-md shadow-sm"},wt={key:0,class:"mt-1 text-red-600 text-sm"},kt={class:"bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"},Ct=e("span",null,"Save",-1),Ht=[Ct],Dt={key:1,class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed"},Vt=e("span",null,"Saving",-1),St=e("svg",{class:"animate-spin ml-3 h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},[e("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),e("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})],-1),jt=[Vt,St],It=e("span",null,"Cancel",-1),Pt=[It],Lt=e("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),zt={class:"fixed inset-0 z-10 overflow-y-auto"},Nt={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},At={class:"bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4"},Ut={class:"flex justify-between items-center"},qt={class:"mt-1"},Mt={class:"text-sm text-gray-500"},Tt={key:0,class:"my-5 flex flex-col gap-y-6"},Bt={key:0,class:"border-l-4 border-green-400 bg-green-50 p-4"},Ft={class:"flex"},Et={class:"flex-shrink-0"},Gt=e("div",{class:"ml-3"},[e("p",{class:"text-sm text-green-700"}," Card is already distributed. ")],-1),Rt={class:""},Kt={class:"relative rounded-md shadow-sm"},Ot={key:0,class:"mt-1 text-red-600 text-sm"},Qt={key:1,class:"my-5 flex flex-col gap-y-6"},Jt={class:"flex justify-between"},Wt=e("span",{class:"sr-only"},"Use setting",-1),Xt=e("svg",{class:"h-3 w-3 text-gray-400",fill:"none",viewBox:"0 0 12 12"},[e("path",{d:"M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"})],-1),Yt=[Xt],Zt=e("svg",{class:"h-3 w-3 text-blue-600",fill:"currentColor",viewBox:"0 0 12 12"},[e("path",{d:"M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"})],-1),$t=[Zt],es={key:0,class:"bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"},ts=e("span",null,"Check",-1),ss=[ts],os={key:1,class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed"},is=e("span",null,"Checking",-1),ls=e("svg",{class:"animate-spin ml-3 h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},[e("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),e("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})],-1),rs=[is,ls],as=e("span",null,"Cancel",-1),ns=[as],ds={key:1,class:"bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"},us=e("span",null,"Update",-1),hs=[us],cs={key:1,class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed"},_s=e("span",null,"Updating",-1),ms=e("svg",{class:"animate-spin ml-3 h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},[e("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),e("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})],-1),fs=[_s,ms],ps=e("span",null,"Cancel",-1),gs=[ps],bs=e("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),vs={class:"fixed inset-0 z-10 overflow-y-auto"},ys={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},xs={class:"bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4"},ws={class:"flex justify-between items-center"},ks=e("div",{class:"mt-1"},[e("p",{class:"text-sm text-gray-500"},"Enter Household Number to view household")],-1),Cs={class:"my-5 flex flex-col gap-y-6"},Hs={class:""},Ds={class:"relative rounded-md shadow-sm"},Vs={key:0,class:"mt-1 text-red-600 text-sm"},Ss={class:"bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"},js=e("span",null,"View",-1),Is=[js],Ps={key:1,class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed"},Ls=e("span",null,"Checking",-1),zs=e("svg",{class:"animate-spin ml-3 h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},[e("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),e("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})],-1),Ns=[Ls,zs],As=e("span",null,"Cancel",-1),Us=[As];function qs(o,s,d,c,t,n){const b=_("CreditCardIcon"),x=_("UserIcon"),v=_("PlusIcon"),P=_("MagnifyingGlassIcon"),p=_("TextInput"),g=_("TransitionChild"),w=_("DialogTitle"),f=_("InputLabel"),k=_("DialogPanel"),C=_("Dialog"),H=_("TransitionRoot"),L=_("CheckCircleIcon"),z=_("Switch"),N=_("AppLayout");return r(),G(N,null,{default:h(()=>[e("div",$,[e("div",ee,[te,e("div",se,[e("button",{onClick:s[0]||(s[0]=(...i)=>n.cardDistribution&&n.cardDistribution(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1 lg:py-1.5 px-5 lg:px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},[l(b,{class:"-ml-0.5 mr-2 h-5 w-5","aria-hidden":"true"}),oe,ie]),e("button",{onClick:s[1]||(s[1]=(...i)=>n.viewHousehold&&n.viewHousehold(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1 lg:py-1.5 px-5 lg:px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},[l(x,{class:"-ml-0.5 mr-2 h-5 w-5","aria-hidden":"true"}),le,re]),e("button",{onClick:s[2]||(s[2]=(...i)=>n.addHousehold&&n.addHousehold(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1 lg:py-1.5 px-4 lg:px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},[l(v,{class:"-ml-0.5 mr-2 h-4 w-4","aria-hidden":"true"}),ae,ne])])]),d.households.length>0?(r(),a("div",de,[e("div",ue,[e("div",he,[e("div",ce,[l(P,{class:"h-5 w-5 text-gray-400","aria-hidden":"true"})]),l(p,{modelValue:t.search_query,"onUpdate:modelValue":s[3]||(s[3]=i=>t.search_query=i),onKeyup:s[4]||(s[4]=i=>n.search()),onChange:s[5]||(s[5]=i=>n.search()),autocomplete:"off",id:"search",type:"text",placeholder:"Search Households",class:"block w-full pl-10 font-medium",required:""},null,8,["modelValue"])])])])):u("",!0),e("div",_e,[d.households.length==0?(r(),a("div",me,[e("div",fe,[pe,ge,be,e("div",ve,[e("button",{onClick:s[6]||(s[6]=(...i)=>n.addHousehold&&n.addHousehold(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},[l(v,{class:"-ml-0.5 mr-2 h-4 w-4","aria-hidden":"true"}),ye])])])])):(r(),a("div",xe,[e("table",we,[ke,e("tbody",Ce,[(r(!0),a(V,null,S(t.display_households,i=>(r(),a("tr",{key:i.id},[e("td",He,[e("div",De,[e("div",Ve,m(i.name),1),e("div",Se,"# "+m(i.hh_id),1)])]),e("td",je,[i.village?(r(),a("div",Ie,m(i.village.name),1)):(r(),a("div",Pe,ze))]),e("td",Ne,m(i.age),1),Ae]))),128)),t.display_households.length==0?(r(),a("tr",Ue,Me)):u("",!0)])])]))]),l(H,{as:"template",show:t.household_form.show_popup},{default:h(()=>[l(C,{as:"div",class:"relative z-10",onClose:s[14]||(s[14]=i=>t.household_form.show_popup=!1)},{default:h(()=>[l(g,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:h(()=>[Te]),_:1}),e("div",Be,[e("div",Fe,[l(g,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:h(()=>[l(k,{class:"relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl"},{default:h(()=>[e("div",Ee,[e("div",Ge,[e("div",null,[l(w,{as:"h3",class:"text-lg font-medium leading-6 text-gray-900"},{default:h(()=>[D(m(t.household_form.popup_title),1)]),_:1}),Re])]),e("div",Ke,[e("div",Oe,[e("div",Qe,[l(f,{for:"household_village",value:"Village"}),j(e("select",{"onUpdate:modelValue":s[7]||(s[7]=i=>t.household_form.village.value=i),id:"household_village",class:"mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm"},[Je,(r(!0),a(V,null,S(d.allocated_villages,i=>(r(),a("option",{key:i.id,value:i.village_id},m(i.village_name.name),9,We))),128))],512),[[I,t.household_form.village.value]]),t.household_form.village.error?(r(),a("p",Xe,"Please select household village")):u("",!0)]),e("div",Ye,[l(f,{for:"name",value:"Name"}),e("div",Ze,[l(p,{modelValue:t.household_form.name.value,"onUpdate:modelValue":s[8]||(s[8]=i=>t.household_form.name.value=i),id:"household_name",type:"text",class:"block w-full font-medium",required:""},null,8,["modelValue"])]),t.household_form.name.error?(r(),a("p",$e,"Please enter valid name")):u("",!0)])]),e("div",et,[e("div",tt,[l(f,{for:"household_mobile_aadhaar",value:"Mobile or Aadhaar"}),e("div",st,[l(p,{modelValue:t.household_form.mobile_aadhaar.value,"onUpdate:modelValue":s[9]||(s[9]=i=>t.household_form.mobile_aadhaar.value=i),maxlength:"12",oninput:"javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);",id:"household_mobile_aadhaar",type:"number",class:"block w-full font-medium",required:""},null,8,["modelValue"]),t.household_form.mobile_aadhaar.value.length>0?(r(),a("div",ot,[t.household_form.mobile_aadhaar.value.length==10?(r(),a("img",it)):u("",!0),t.household_form.mobile_aadhaar.value.length>11?(r(),a("img",lt)):u("",!0)])):u("",!0)]),t.household_form.mobile_aadhaar.error?(r(),a("p",rt,"Please enter valid mobile or aadhaar")):u("",!0)]),e("div",at,[l(f,{for:"household_social_status",value:"Social Status"}),j(e("select",{"onUpdate:modelValue":s[10]||(s[10]=i=>t.household_form.social_status.value=i),id:"household_social_status",class:"mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm"},mt,512),[[I,t.household_form.social_status.value]]),t.household_form.social_status.error?(r(),a("p",ft,"Please select social status")):u("",!0)])]),e("div",pt,[e("div",gt,[l(f,{for:"household_state",value:"State"}),e("div",bt,[l(p,{disabled:"",value:d.state,id:"household_state",type:"text",class:"block w-full font-medium",required:""},null,8,["value"])]),vt]),e("div",yt,[l(f,{for:"household_age",value:"Age"}),e("div",xt,[l(p,{modelValue:t.household_form.age.value,"onUpdate:modelValue":s[11]||(s[11]=i=>t.household_form.age.value=i),maxlength:"3",oninput:"javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);",id:"household_age",type:"number",class:"block w-full font-medium",required:""},null,8,["modelValue"])]),t.household_form.age.error?(r(),a("p",wt,m(t.household_form.age.error_msg),1)):u("",!0)])])])]),e("div",kt,[t.household_form.processing?t.household_form.processing?(r(),a("button",Dt,jt)):u("",!0):(r(),a("button",{key:0,onClick:s[12]||(s[12]=(...i)=>n.validateForm&&n.validateForm(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},Ht)),t.household_form.processing?u("",!0):(r(),a("button",{key:2,onClick:s[13]||(s[13]=i=>t.household_form.show_popup=!1),type:"button",class:"mr-3 group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},Pt))])]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"]),l(H,{as:"template",show:t.card_distribution_form.show_popup},{default:h(()=>[l(C,{as:"div",class:"relative z-10",onClose:s[21]||(s[21]=i=>t.card_distribution_form.show_popup=!1)},{default:h(()=>[l(g,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:h(()=>[Lt]),_:1}),e("div",zt,[e("div",Nt,[l(g,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:h(()=>[l(k,{class:"relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm"},{default:h(()=>[e("div",At,[e("div",Ut,[e("div",null,[l(w,{as:"h3",class:"text-lg font-medium leading-6 text-gray-900"},{default:h(()=>[D(m(t.card_distribution_form.popup_title),1)]),_:1}),e("div",qt,[e("p",Mt,m(t.card_distribution_form.popup_description),1)])])]),t.card_distribution_form.view=="enter_hhid"?(r(),a("div",Tt,[t.card_distribution_form.already_distributed?(r(),a("div",Bt,[e("div",Ft,[e("div",Et,[l(L,{class:"h-5 w-5 text-green-500","aria-hidden":"true"})]),Gt])])):u("",!0),e("div",Rt,[l(f,{for:"view_household_number",value:"Household Number"}),e("div",Kt,[l(p,{modelValue:t.card_distribution_form.hh_id.value,"onUpdate:modelValue":s[15]||(s[15]=i=>t.card_distribution_form.hh_id.value=i),id:"view_household_number",type:"number",class:"block w-full font-medium",required:""},null,8,["modelValue"])]),t.card_distribution_form.hh_id.error?(r(),a("p",Ot,m(t.card_distribution_form.hh_id.error_msg),1)):u("",!0)])])):(r(),a("div",Qt,[e("div",Jt,[l(f,{for:"card_distributed",value:"Card Distributed?"}),l(z,{modelValue:t.card_distribution_form.has_distributed,"onUpdate:modelValue":s[16]||(s[16]=i=>t.card_distribution_form.has_distributed=i),class:y([t.card_distribution_form.has_distributed?"bg-blue-600":"bg-gray-200","relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"])},{default:h(()=>[Wt,e("span",{class:y([t.card_distribution_form.has_distributed?"translate-x-5":"translate-x-0","pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"])},[e("span",{class:y([t.card_distribution_form.has_distributed?"opacity-0 ease-out duration-100":"opacity-100 ease-in duration-200","absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"]),"aria-hidden":"true"},Yt,2),e("span",{class:y([t.card_distribution_form.has_distributed?"opacity-100 ease-in duration-200":"opacity-0 ease-out duration-100","absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"]),"aria-hidden":"true"},$t,2)],2)]),_:1},8,["modelValue","class"])])]))]),t.card_distribution_form.view=="enter_hhid"?(r(),a("div",es,[t.card_distribution_form.processing?t.card_distribution_form.processing?(r(),a("button",os,rs)):u("",!0):(r(),a("button",{key:0,onClick:s[17]||(s[17]=(...i)=>n.checkCardDistribution&&n.checkCardDistribution(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},ss)),t.card_distribution_form.processing?u("",!0):(r(),a("button",{key:2,onClick:s[18]||(s[18]=i=>t.card_distribution_form.show_popup=!1),type:"button",class:"mr-3 group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},ns))])):(r(),a("div",ds,[t.card_distribution_form.processing?t.card_distribution_form.processing?(r(),a("button",cs,fs)):u("",!0):(r(),a("button",{key:0,onClick:s[19]||(s[19]=(...i)=>n.updateCardDistributionStatus&&n.updateCardDistributionStatus(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},hs)),t.card_distribution_form.processing?u("",!0):(r(),a("button",{key:2,onClick:s[20]||(s[20]=i=>t.card_distribution_form.show_popup=!1),type:"button",class:"mr-3 group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},gs))]))]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"]),l(H,{as:"template",show:t.view_household_form.show_popup},{default:h(()=>[l(C,{as:"div",class:"relative z-10",onClose:s[25]||(s[25]=i=>t.view_household_form.show_popup=!1)},{default:h(()=>[l(g,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:h(()=>[bs]),_:1}),e("div",vs,[e("div",ys,[l(g,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:h(()=>[l(k,{class:"relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm"},{default:h(()=>[e("div",xs,[e("div",ws,[e("div",null,[l(w,{as:"h3",class:"text-lg font-medium leading-6 text-gray-900"},{default:h(()=>[D("View Household")]),_:1}),ks])]),e("div",Cs,[e("div",Hs,[l(f,{for:"view_household_number",value:"Household Number"}),e("div",Ds,[l(p,{modelValue:t.view_household_form.hh_id.value,"onUpdate:modelValue":s[22]||(s[22]=i=>t.view_household_form.hh_id.value=i),id:"view_household_number",type:"number",class:"block w-full font-medium",required:""},null,8,["modelValue"])]),t.view_household_form.hh_id.error?(r(),a("p",Vs,m(t.view_household_form.hh_id.error_msg),1)):u("",!0)])])]),e("div",Ss,[t.view_household_form.processing?t.view_household_form.processing?(r(),a("button",Ps,Ns)):u("",!0):(r(),a("button",{key:0,onClick:s[23]||(s[23]=(...i)=>n.viewHouseholdProcess&&n.viewHouseholdProcess(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},Is)),t.view_household_form.processing?u("",!0):(r(),a("button",{key:2,onClick:s[24]||(s[24]=i=>t.view_household_form.show_popup=!1),type:"button",class:"mr-3 group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},Us))])]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"])])]),_:1})}const Qs=R(Z,[["render",qs]]);export{Qs as default};

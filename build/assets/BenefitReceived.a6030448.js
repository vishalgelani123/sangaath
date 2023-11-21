import{A as L,N as q,_ as B,U,o as R,f as M}from"./AppLayout.c471b81a.js";import{L as z,a0 as P,B as d,o as r,c as N,w as c,a as e,b as a,g as h,n as u,e as n,f as _,F as A,i as F,t as y}from"./app.c9482037.js";import{_ as H}from"./TextInput.86ba2c92.js";import{_ as E}from"./InputLabel.5855d489.js";import{_ as G}from"./_plugin-vue_export-helper.cdc0426e.js";import{r as K,a as Y,b as Q}from"./MagnifyingGlassIcon.72cf383a.js";import{r as X,a as J,b as O,c as W}from"./XCircleIcon.b480e10e.js";import{r as Z}from"./CheckCircleIcon.00a0f7b3.js";import{l as $}from"./switch.67ed66d7.js";const ee={components:{AppLayout:L,TextInput:H,InputLabel:E,Dialog:q,DialogPanel:B,DialogTitle:U,TransitionChild:R,TransitionRoot:M,Switch:$,Link:z,MagnifyingGlassIcon:K,PlusIcon:Y,ExclamationTriangleIcon:Q,EyeIcon:X,CloudArrowUpIcon:J,CheckIcon:O,CheckCircleIcon:Z,XCircleIcon:W},props:["initial_forms"],data(){return{searched_forms:[],loaded_forms:this.initial_forms,display_forms:this.initial_forms,last_search_query:"",search_query:"",is_search_complete:!1,is_loading:!1,has_reached_search_bottom:!1,has_reached_bottom:!1,search_loaded_rows:0,loaded_rows:50,application_form:{show_popup:!1,popup_title:"",form_id:"",has_benefitted:!1,reject_reason:{value:"",error:!1},discrepancy:{value:"",error:!1},date:{value:"",error:!1},processing:!1},documents:{},delete_form:{site_name:"",form_id:null,show_popup:!1,processing:!1}}},mounted(){window.addEventListener("scroll",function(){const o=window.innerHeight+window.scrollY,l=document.body.scrollHeight-o,p=200;!(this.search_query.length>0?this.has_reached_search_bottom:this.has_reached_bottom)&&!this.is_loading&&l<p&&(this.is_loading=!0,this.loadMoreData())}.bind(this))},methods:{debouncedSearch:P.exports.debounce(function(){this.search()},500),search(){var o=this.search_query.toString().toLowerCase().trim();o.length>0&&o!=this.last_search_query&&(this.has_reached_search_bottom=!1,this.loadMoreData(!0))},loadMoreData(o=!1){o&&(this.search_loaded_rows=0,this.searched_forms=[],this.has_reached_search_bottom=!1);let s=null,l=this.loaded_rows;this.search_query.length>0&&(s=`&search=${this.search_query}`,this.last_search_query=this.search_query.toString().toLowerCase(),l=this.search_loaded_rows),axios.get(`/followup/benefit-received?is_ajax=1&skip=${l}${s!=null?s:""}`).then(function(p){const t=p.data;t.rows&&(s?(this.searched_forms.push(...t.rows),this.search_loaded_rows=this.searched_forms.length):(this.loaded_forms.push(...t.rows),this.loaded_rows=this.loaded_forms.length),this.is_loading=!1,this.is_search_complete=!0,t.rows.length==0&&(s?this.has_reached_search_bottom=!0:this.has_reached_bottom=!0))}.bind(this))},startApplication(o){var s;this.application_form.popup_title=(s=o.beneficiary)==null?void 0:s.name,this.application_form.form_id=o.id,this.application_form.show_popup=!0},validateForm(){var o=this.application_form;o.date.error=!1,o.reject_reason.error=!1,o.discrepancy.error=!1;var s=this.application_form.has_benefitted,l=o.date.value.toString();if(l.length==0){o.date.error=!0;return}var p="",t="";if(!s){var p=o.reject_reason.value.toString();if(p.length==0){o.reject_reason.error=!0;return}var t=o.discrepancy.value.toString();if(t.length==0){o.discrepancy.error=!0;return}}this.updateStatus(s,l,p,t)},updateStatus(o,s,l,p){this.application_form.processing=!0;var t=new FormData;t.append("form_id",this.application_form.form_id),t.append("has_benefitted",o?1:-1),t.append("date",s),t.append("reject_reason",l),t.append("discrepancy",p);var m=this;axios.post("/followup/update-status",t).then(function(f){m.application_form.processing=!1;var x=f.data;x.status==1&&m.$inertia.visit("/followup/today",{only:["initial_forms"]})})}}},te={class:"flex-1"},se={class:"flex items-center justify-between"},oe={class:"w-full border-b border-gray-200"},ae={class:"-mb-px flex","aria-label":"Tabs"},ie={key:0,class:"mt-6 px-4 sm:px-6 lg:px-8"},re={class:"max-w-sm"},ne={class:"relative rounded-md shadow-sm"},le={class:"pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"},ce={class:"mt-6"},de={key:0,class:"mt-20 inline-block min-w-full align-middle"},pe=e("div",{class:"flex items-center flex-col"},[e("img",{src:"/images/document-complete.png",class:"w-72",alt:""}),e("h3",{class:"mt-2 text-lg font-semibold text-gray-900"},"No Follow Ups"),e("p",{class:"mt-1 text-sm text-gray-500"},"You have no follow up for today.")],-1),_e=[pe],ue={key:1,class:"inline-block min-w-full border-b border-gray-200 align-middle"},me={class:"min-w-full"},fe=e("thead",null,[e("tr",{class:"border-t border-gray-200"},[e("th",{class:"border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900",scope:"col"},[e("span",{class:"lg:pl-2"},"Name")]),e("th",{class:"hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell",scope:"col"},"Scheme"),e("th",{class:"hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell",scope:"col"},"Application date")])],-1),he={class:"divide-y divide-gray-100 bg-white"},ye={class:"whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900"},ge={class:"lg:pl-2"},be={class:"font-medium text-gray-900"},xe={class:"text-gray-500"},ve={class:"hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell"},we={class:"hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell"},ke={key:0},je=e("td",{colspan:"5",class:"whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900"},[e("span",{class:"lg:pl-2 text-gray-600 font-medium"},"No results found!")],-1),Ce=[je],Se=e("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),Ve={class:"fixed inset-0 z-10 overflow-y-auto"},De={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},Te={class:"bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4"},Ie={class:"mb-5 flex justify-between items-center"},Le=e("div",{class:"mt-1"},[e("p",{class:"text-sm text-gray-500"},"Select the details to update status")],-1),qe={class:"my-5 flex flex-col gap-y-5"},Be={class:"flex justify-between"},Ue=e("span",{class:"sr-only"},"Use setting",-1),Re=e("svg",{class:"h-3 w-3 text-gray-400",fill:"none",viewBox:"0 0 12 12"},[e("path",{d:"M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2",stroke:"currentColor","stroke-width":"2","stroke-linecap":"round","stroke-linejoin":"round"})],-1),Me=[Re],ze=e("svg",{class:"h-3 w-3 text-blue-600",fill:"currentColor",viewBox:"0 0 12 12"},[e("path",{d:"M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"})],-1),Pe=[ze],Ne={class:""},Ae={class:"relative rounded-md shadow-sm"},Fe={key:0,class:"mt-1 text-red-600 text-sm"},He={key:0,class:""},Ee={class:"relative rounded-md shadow-sm"},Ge={key:0,class:"mt-1 text-red-600 text-sm"},Ke={key:1,class:""},Ye={class:"relative rounded-md shadow-sm"},Qe={key:0,class:"mt-1 text-red-600 text-sm"},Xe={class:"bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"},Je=e("span",null,"Update",-1),Oe=[Je],We={key:1,class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed"},Ze=e("span",null,"Updating",-1),$e=e("svg",{class:"animate-spin ml-3 h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},[e("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),e("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})],-1),et=[Ze,$e],tt=e("span",null,"Cancel",-1),st=[tt];function ot(o,s,l,p,t,m){const f=d("Link"),x=d("MagnifyingGlassIcon"),g=d("TextInput"),v=d("TransitionChild"),C=d("DialogTitle"),b=d("InputLabel"),S=d("Switch"),V=d("DialogPanel"),D=d("Dialog"),T=d("TransitionRoot"),I=d("AppLayout");return r(),N(I,null,{default:c(()=>[e("div",te,[e("div",se,[e("div",oe,[e("nav",ae,[a(f,{href:"/followup/today",class:u(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:c(()=>[h("Today")]),_:1}),a(f,{href:"/followup/previous",class:u(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:c(()=>[h("Previous Pending")]),_:1}),a(f,{class:u(["border-blue-500 text-blue-600","w-1/3 py-4 px-1 text-center border-b-2 font-semibold text-sm"]),"aria-current":"page"},{default:c(()=>[h("Benefit Received")]),_:1}),a(f,{href:"/followup/rejected",class:u(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/3 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:c(()=>[h("Rejected")]),_:1})])])]),l.initial_forms.length>0?(r(),n("div",ie,[e("div",re,[e("div",ne,[e("div",le,[a(x,{class:"h-5 w-5 text-gray-400","aria-hidden":"true"})]),a(g,{modelValue:t.search_query,"onUpdate:modelValue":s[0]||(s[0]=i=>t.search_query=i),onKeyup:m.debouncedSearch,onChange:m.debouncedSearch,autocomplete:"off",id:"search",type:"text",placeholder:"Search Benefit Received",class:"block w-full pl-10 font-medium",required:""},null,8,["modelValue","onKeyup","onChange"])])])])):_("",!0),e("div",ce,[l.initial_forms.length==0?(r(),n("div",de,_e)):(r(),n("div",ue,[e("table",me,[fe,e("tbody",he,[(r(!0),n(A,null,F(t.search_query.length>0&&t.is_search_complete?t.searched_forms:t.loaded_forms,i=>{var w,k,j;return r(),n("tr",{key:i.id},[e("td",ye,[e("div",ge,[e("div",be,y((w=i.beneficiary)==null?void 0:w.name),1),e("div",xe,y((j=(k=i.beneficiary)==null?void 0:k.village)==null?void 0:j.name),1)])]),e("td",ve,y(i.scheme.name),1),e("td",we,y(i.govt_submission_date),1)])}),128)),t.display_forms.length==0?(r(),n("tr",ke,Ce)):_("",!0)])])]))]),a(T,{as:"template",show:t.application_form.show_popup},{default:c(()=>[a(D,{as:"div",class:"relative z-10",onClose:s[7]||(s[7]=i=>t.application_form.show_popup=!1)},{default:c(()=>[a(v,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:c(()=>[Se]),_:1}),e("div",Ve,[e("div",De,[a(v,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:c(()=>[a(V,{class:"relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xs"},{default:c(()=>[e("div",Te,[e("div",Ie,[e("div",null,[a(C,{as:"h3",class:"text-lg font-medium leading-6 text-gray-900"},{default:c(()=>[h(y(t.application_form.popup_title),1)]),_:1}),Le])]),e("div",qe,[e("div",Be,[a(b,{for:"update_status_date",value:"Has benefited?"}),a(S,{modelValue:t.application_form.has_benefitted,"onUpdate:modelValue":s[1]||(s[1]=i=>t.application_form.has_benefitted=i),class:u([t.application_form.has_benefitted?"bg-blue-600":"bg-gray-200","relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"])},{default:c(()=>[Ue,e("span",{class:u([t.application_form.has_benefitted?"translate-x-5":"translate-x-0","pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"])},[e("span",{class:u([t.application_form.has_benefitted?"opacity-0 ease-out duration-100":"opacity-100 ease-in duration-200","absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"]),"aria-hidden":"true"},Me,2),e("span",{class:u([t.application_form.has_benefitted?"opacity-100 ease-in duration-200":"opacity-0 ease-out duration-100","absolute inset-0 flex h-full w-full items-center justify-center transition-opacity"]),"aria-hidden":"true"},Pe,2)],2)]),_:1},8,["modelValue","class"])]),e("div",Ne,[a(b,{for:"application_date",value:t.application_form.has_benefitted?"Date":"Follow Up Date"},null,8,["value"]),e("div",Ae,[a(g,{modelValue:t.application_form.date.value,"onUpdate:modelValue":s[2]||(s[2]=i=>t.application_form.date.value=i),id:"application_date",type:"date",class:"block w-full font-medium",required:""},null,8,["modelValue"])]),t.application_form.date.error?(r(),n("p",Fe,"Please select valid date")):_("",!0)]),t.application_form.has_benefitted?_("",!0):(r(),n("div",He,[a(b,{for:"name",value:"Reject reason"}),e("div",Ee,[a(g,{modelValue:t.application_form.reject_reason.value,"onUpdate:modelValue":s[3]||(s[3]=i=>t.application_form.reject_reason.value=i),id:"site_name",type:"text",class:"block w-full font-medium",required:""},null,8,["modelValue"])]),t.application_form.reject_reason.error?(r(),n("p",Ge,"Please enter reject reason")):_("",!0)])),t.application_form.has_benefitted?_("",!0):(r(),n("div",Ke,[a(b,{for:"discrepancy",value:"Discrepancy"}),e("div",Ye,[a(g,{modelValue:t.application_form.discrepancy.value,"onUpdate:modelValue":s[4]||(s[4]=i=>t.application_form.discrepancy.value=i),id:"discrepancy",type:"text",class:"block w-full font-medium",required:""},null,8,["modelValue"])]),t.application_form.discrepancy.error?(r(),n("p",Qe,"Please enter discrepancy")):_("",!0)]))])]),e("div",Xe,[t.application_form.processing?t.application_form.processing?(r(),n("button",We,et)):_("",!0):(r(),n("button",{key:0,onClick:s[5]||(s[5]=(...i)=>m.validateForm&&m.validateForm(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},Oe)),t.application_form.processing?_("",!0):(r(),n("button",{key:2,onClick:s[6]||(s[6]=i=>t.application_form.show_popup=!1),type:"button",class:"mr-3 group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},st))])]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"])])]),_:1})}const ut=G(ee,[["render",ot]]);export{ut as default};

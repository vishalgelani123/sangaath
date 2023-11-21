import{A as S,N,_ as P,U as L,o as V,f as A,r as B}from"./AppLayout.c471b81a.js";import{_ as j}from"./TextInput.86ba2c92.js";import{_ as q}from"./InputLabel.5855d489.js";import{B as d,o as s,c as M,w as c,a as e,b as n,e as i,f as _,F as g,i as v,g as x,t as m,D as k,N as w}from"./app.c9482037.js";import{_ as z}from"./_plugin-vue_export-helper.cdc0426e.js";import{r as G,a as E,b as H}from"./MagnifyingGlassIcon.72cf383a.js";const R={components:{AppLayout:S,TextInput:j,InputLabel:q,Dialog:N,DialogPanel:P,DialogTitle:L,TransitionChild:V,TransitionRoot:A,MagnifyingGlassIcon:G,PlusIcon:E,ExclamationTriangleIcon:H,ArrowUpTrayIcon:B},props:["all_bulk_uploads","sites","templates"],data(){return{display_bulk_uploads:this.all_bulk_uploads,search_query:"",bulk_upload_form:{show_popup:!1,popup_title:"Upload File",site:{value:"",error:!1},type:{value:"",error:!1},file:{value:null,error:!1},file_error:null,save_type:"new",site_id:null,processing:!1}}},methods:{search(){var r=this.search_query.toString().toLowerCase();if(r.length>0){this.display_bulk_uploads=[];for(var t in this.all_bulk_uploads){var a=this.all_bulk_uploads[t];(a.file_type.toString().toLowerCase().includes(r)||a.uploaded_at.toString().toLowerCase().includes(r))&&this.display_bulk_uploads.push(a)}}else this.display_bulk_uploads=this.all_bulk_uploads},uploadFile(){this.bulk_upload_form.site.error=!1,this.bulk_upload_form.type.error=!1,this.bulk_upload_form.file.error=!1,this.bulk_upload_form.file_error=null,this.bulk_upload_form.save_type="new",this.bulk_upload_form.popup_title="Upload File",this.bulk_upload_form.show_popup=!0},handleFile(r){this.bulk_upload_form.file.value=r.target.files},validateForm(){this.bulk_upload_form.site.error=!1,this.bulk_upload_form.type.error=!1,this.bulk_upload_form.file.error=!1,this.bulk_upload_form.file_error=null,console.log(this.bulk_upload_form.file.value);var r=this.bulk_upload_form.site.value.toString();if(r.length==0){this.bulk_upload_form.site.error=!0;return}var t=this.bulk_upload_form.type.value.toString();if(t.length==0){this.bulk_upload_form.type.error=!0;return}const a=this.bulk_upload_form.file.value;if(!a||a.length<1){this.bulk_upload_form.file.error=!0;return}this.uploadFileProcess(r,t)},uploadFileProcess(r,t){this.bulk_upload_form.processing=!0;const a=this.bulk_upload_form.file.value[0];var p=new FormData;p.append("site_id",r),p.append("type",t),p.append("file",a),p.append("save_type",this.bulk_upload_form.save_type);var l=this;axios.post("/bulk-upload/upload",p).then(function(u){l.bulk_upload_form.processing=!1;var f=u.data;f.status==1?l.$inertia.visit("/bulk-upload",{only:["all_bulk_uploads"]}):l.bulk_upload_form.file_error=f})},deleteProcess(){this.delete_form.processing=!0;var r=new FormData;r.append("site_id",this.delete_form.site_id);var t=this;axios.post("/sites/delete",r).then(function(a){t.delete_form.processing=!1;var p=a.data;p.status==1&&t.$inertia.visit("/sites",{only:["all_bulk_uploads"]})})}}},K={class:"flex-1"},O={class:"border-b border-gray-200 px-4 py-3 flex items-center justify-between sm:px-6 lg:px-8"},Q=e("div",{class:"min-w-0 flex-1"},[e("h1",{class:"text-lg font-medium leading-6 text-gray-900 sm:truncate"},"All Bulk Uploads")],-1),J={class:"flex mt-0 ml-4"},W=e("span",null,"Upload Now",-1),X={key:0,class:"mt-6 px-4 sm:px-6 lg:px-8"},Y={class:"max-w-sm"},Z={class:"relative rounded-md shadow-sm"},$={class:"pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"},ee={class:"mt-6"},te={key:0,class:"mt-20 inline-block min-w-full align-middle"},le={class:"flex items-center flex-col"},oe=e("img",{src:"/images/file.png",class:"w-72",alt:""},null,-1),se=e("h3",{class:"mt-2 text-lg font-semibold text-gray-900"},"No bulk uploads",-1),ie=e("p",{class:"mt-1 text-sm text-gray-500"},"Get started by uploading a file.",-1),ae={class:"mt-6"},re=e("span",null,"Upload Now",-1),ne={key:1,class:"inline-block min-w-full border-b border-gray-200 align-middle"},ue={class:"min-w-full"},de=e("thead",null,[e("tr",{class:"border-t border-gray-200"},[e("th",{class:"border-b border-gray-200 bg-gray-50 px-6 py-3 text-left text-sm font-semibold text-gray-900",scope:"col"},[e("span",{class:"lg:pl-2"},"File Type")]),e("th",{class:"hidden border-b border-gray-200 bg-gray-50 px-6 py-3 text-right text-sm font-semibold text-gray-900 md:table-cell",scope:"col"},"Uploaded On"),e("th",{class:"border-b border-gray-200 bg-gray-50 py-3 pr-6 text-right text-sm font-semibold text-gray-900",scope:"col"})])],-1),_e={class:"divide-y divide-gray-100 bg-white"},pe={class:"w-1/2 max-w-0 whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900"},ce={class:"flex items-center space-x-3 lg:pl-2"},fe={class:"hidden whitespace-nowrap px-6 py-3 text-right text-sm text-gray-500 md:table-cell"},me={class:"whitespace-nowrap px-6 py-3 text-right text-sm font-medium"},he=["href"],be={key:0},ye=e("td",{colspan:"5",class:"whitespace-nowrap px-6 py-3 text-sm font-medium text-gray-900"},[e("span",{class:"lg:pl-2 text-gray-600 font-medium"},"No results found!")],-1),ge=[ye],ve=e("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),xe={class:"fixed inset-0 z-10 overflow-y-auto"},ke={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},we={class:"bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4"},Te={class:"text-left"},Fe=e("div",{class:"mt-1"},[e("p",{class:"text-sm text-gray-500"},"Enter the basic details to continue")],-1),Ce={class:"my-5 flex flex-col gap-y-7"},De={key:0,class:"rounded-md bg-red-50 p-4"},Ue={class:"flex"},Ie={key:0,class:"text-sm font-medium text-red-800"},Se={key:1,class:"text-sm font-medium text-red-800"},Ne=["href"],Pe={class:""},Le=e("option",{value:"",selected:"",disabled:""},"Select Site",-1),Ve=["value"],Ae={key:0,class:"mt-1 text-red-600 text-sm"},Be={class:""},je={class:"flex justify-between items-center"},qe={key:0},Me=["href"],ze=["href"],Ge=e("option",{value:"",selected:"",disabled:""},"Select File Type",-1),Ee=e("option",{value:"hh_head"},"Household Heads",-1),He=e("option",{value:"individual_members"},"Individual Members",-1),Re=[Ge,Ee,He],Ke={key:0,class:"mt-1 text-red-600 text-sm"},Oe={class:""},Qe={class:"relative rounded-md shadow-sm"},Je={key:0,class:"mt-1 text-red-600 text-sm"},We={class:"bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"},Xe=e("span",null,"Upload",-1),Ye=[Xe],Ze={key:1,class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed"},$e=e("span",null,"Uploading",-1),et=e("svg",{class:"animate-spin ml-3 h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},[e("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),e("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})],-1),tt=[$e,et],lt=e("span",null,"Cancel",-1),ot=[lt];function st(r,t,a,p,l,u){const f=d("ArrowUpTrayIcon"),T=d("MagnifyingGlassIcon"),b=d("TextInput"),y=d("TransitionChild"),F=d("DialogTitle"),h=d("InputLabel"),C=d("DialogPanel"),D=d("Dialog"),U=d("TransitionRoot"),I=d("AppLayout");return s(),M(I,null,{default:c(()=>[e("div",K,[e("div",O,[Q,e("div",J,[e("button",{onClick:t[0]||(t[0]=(...o)=>u.uploadFile&&u.uploadFile(...o)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},[n(f,{class:"-ml-0.5 mr-2 h-4 w-4","aria-hidden":"true"}),W])])]),a.all_bulk_uploads.length>0?(s(),i("div",X,[e("div",Y,[e("div",Z,[e("div",$,[n(T,{class:"h-5 w-5 text-gray-400","aria-hidden":"true"})]),n(b,{modelValue:l.search_query,"onUpdate:modelValue":t[1]||(t[1]=o=>l.search_query=o),onKeyup:t[2]||(t[2]=o=>u.search()),onChange:t[3]||(t[3]=o=>u.search()),autocomplete:"off",id:"search",type:"text",placeholder:"Search Bulk Uploads",class:"block w-full pl-10 font-medium",required:""},null,8,["modelValue"])])])])):_("",!0),e("div",ee,[a.all_bulk_uploads.length==0?(s(),i("div",te,[e("div",le,[oe,se,ie,e("div",ae,[e("button",{onClick:t[4]||(t[4]=(...o)=>u.uploadFile&&u.uploadFile(...o)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-5 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},[n(f,{class:"-ml-0.5 mr-2 h-4 w-4","aria-hidden":"true"}),re])])])])):(s(),i("div",ne,[e("table",ue,[de,e("tbody",_e,[(s(!0),i(g,null,v(l.display_bulk_uploads,o=>(s(),i("tr",{key:o.id},[e("td",pe,[e("div",ce,m(o.file_type),1)]),e("td",fe,m(o.uploaded_at),1),e("td",me,[e("a",{href:o.download_link,target:"_blank",class:"text-blue-600 hover:text-blue-900"},"Download",8,he)])]))),128)),l.display_bulk_uploads.length==0?(s(),i("tr",be,ge)):_("",!0)])])]))]),n(U,{as:"template",show:l.bulk_upload_form.show_popup},{default:c(()=>[n(D,{as:"div",class:"relative z-10",onClose:t[9]||(t[9]=o=>l.bulk_upload_form.show_popup=!1)},{default:c(()=>[n(y,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:c(()=>[ve]),_:1}),e("div",xe,[e("div",ke,[n(y,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:c(()=>[n(C,{class:"relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm"},{default:c(()=>[e("div",we,[e("div",Te,[n(F,{as:"h3",class:"text-lg font-medium leading-6 text-gray-900"},{default:c(()=>[x(m(l.bulk_upload_form.popup_title),1)]),_:1}),Fe]),e("div",Ce,[l.bulk_upload_form.file_error?(s(),i("div",De,[e("div",Ue,[e("div",null,[l.bulk_upload_form.file_error.error=="invalid_header"?(s(),i("h3",Ie," The provided file is invalid. Please upload a valid format ")):(s(),i("h3",Se,[x(" There are errors in the file you provided. "),e("a",{href:l.bulk_upload_form.file_error.download_link,class:"hover:underline font-semibold"},"Download File",8,Ne)]))])])])):_("",!0),e("div",Pe,[n(h,{for:"bulk_upload_site",value:"Site"}),k(e("select",{"onUpdate:modelValue":t[5]||(t[5]=o=>l.bulk_upload_form.site.value=o),id:"bulk_upload_site",class:"mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm"},[Le,(s(!0),i(g,null,v(a.sites,o=>(s(),i("option",{value:o.id,key:o.id},m(o.name),9,Ve))),128))],512),[[w,l.bulk_upload_form.site.value]]),l.bulk_upload_form.site.error?(s(),i("p",Ae,"Please select a site")):_("",!0)]),e("div",Be,[e("div",je,[n(h,{for:"bulk_upload_type",value:"Type"}),l.bulk_upload_form.type.value.length>0?(s(),i("div",qe,[l.bulk_upload_form.type.value=="hh_head"?(s(),i("a",{key:0,href:a.templates.hh_head,class:"mb-3 text-xs text-blue-600 font-medium"},"Download Template",8,Me)):(s(),i("a",{key:1,href:a.templates.hh_individual,class:"mb-3 text-xs text-blue-600 font-medium"},"Download Template",8,ze))])):_("",!0)]),k(e("select",{"onUpdate:modelValue":t[6]||(t[6]=o=>l.bulk_upload_form.type.value=o),id:"bulk_upload_type",class:"mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm"},Re,512),[[w,l.bulk_upload_form.type.value]]),l.bulk_upload_form.type.error?(s(),i("p",Ke,"Please select file type")):_("",!0)]),e("div",Oe,[n(h,{for:"bulk_upload_file",value:"File"}),e("div",Qe,[n(b,{onChange:u.handleFile,ref:"fileInput",accept:"text/csv",id:"bulk_upload_file",type:"file",class:"block w-full font-medium",required:""},null,8,["onChange"])]),l.bulk_upload_form.file.error?(s(),i("p",Je,"Please select a file")):_("",!0)])])]),e("div",We,[l.bulk_upload_form.processing?l.bulk_upload_form.processing?(s(),i("button",Ze,tt)):_("",!0):(s(),i("button",{key:0,onClick:t[7]||(t[7]=(...o)=>u.validateForm&&u.validateForm(...o)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},Ye)),l.bulk_upload_form.processing?_("",!0):(s(),i("button",{key:2,onClick:t[8]||(t[8]=o=>l.bulk_upload_form.show_popup=!1),type:"button",class:"mr-3 group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},ot))])]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"])])]),_:1})}const _t=z(R,[["render",st]]);export{_t as default};

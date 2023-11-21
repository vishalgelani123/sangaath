import{A as P,N as U,_ as L,U as S,o as V,f as N,a as O}from"./AppLayout.c471b81a.js";import{_ as B}from"./TextInput.86ba2c92.js";import{_ as G}from"./InputLabel.5855d489.js";import{V as H,r as M,a as F,b as Y}from"./vue3-apexcharts.common.85077902.js";import{B as l,o as n,c as E,w as r,a as e,b as s,t as a,g as C,D as X,N as q,e as d,i as D,F as j,f as x,n as h}from"./app.c9482037.js";import{_ as J}from"./_plugin-vue_export-helper.cdc0426e.js";import{l as K}from"./switch.67ed66d7.js";import{y as Q,O as W,g as Z}from"./radio-group.b3bc3fc0.js";const $={components:{apexchart:H,AppLayout:P,TextInput:B,InputLabel:G,Dialog:U,DialogPanel:L,DialogTitle:S,TransitionChild:V,TransitionRoot:N,Switch:K,RadioGroup:Q,RadioGroupLabel:W,RadioGroupOption:Z,MapPinIcon:M,HomeIcon:O,UserGroupIcon:F,DocumentTextIcon:Y},props:["overview","followup","applications","users"],data(){return{charts:{followup:{series:[{name:"Today",data:this.followup.today_followups},{name:"Previous",data:this.followup.previous_followups}],options:{chart:{type:"bar",height:400,stacked:!0,toolbar:{show:!1},zoom:{enabled:!1}},responsive:[{breakpoint:480,options:{legend:{position:"bottom",offsetX:-10,offsetY:0}}}],plotOptions:{bar:{horizontal:!1,borderRadius:2}},xaxis:{type:"string",categories:this.followup.site_names},legend:{position:"top",offsetY:0},fill:{opacity:1}}},applications:{series:Object.values(this.applications),options:{chart:{width:380,type:"pie"},labels:Object.keys(this.applications),responsive:[{breakpoint:480,options:{chart:{width:200},legend:{position:"bottom"}}}]}}},daily_report:{show_popup:!1,popup_title:"",user:{value:"",error:!1},processing:!1},daily_report_viewer:{show_popup:!1,popup_title:"",report:null}}},methods:{dailyReport(){this.daily_report.user.error=!1,this.daily_report.show_popup=!0},fetchDailyReport(){var u=this.daily_report;u.user.error=!1;var o=u.user.value.toString();if(o.length==0){u.user.error=!0;return}u.processing=!0;var c=new FormData;c.append("user_id",o);var m=this;axios.post("/dashboard/daily-report",c).then(function(t){var p=t.data;if(u.processing=!1,p.status==1){var _=p.data.report;m.daily_report.show_popup=!1,m.daily_report_viewer.report=_,m.daily_report_viewer.show_popup=!0}})}}},ee={class:"flex-1"},te={class:"border-b border-gray-200 px-4 py-5 flex items-center justify-between sm:px-6 lg:px-8"},se=e("div",{class:"min-w-0 flex-1"},[e("h1",{class:"text-lg font-medium leading-6 text-gray-900 sm:truncate"},"Home")],-1),oe={class:"flex gap-4 mt-0 ml-4"},ie=e("span",null,"Daily Report",-1),re={class:"mt-6 px-4 sm:px-6 lg:px-8"},le=e("h2",{class:"text-sm font-medium text-gray-900"},"Overview",-1),ae={role:"list",class:"mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-6 xl:grid-cols-4"},ne={class:"relative col-span-1 flex rounded-md shadow-sm"},ce={class:h(["bg-pink-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md"])},de={class:"flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white"},pe={class:"flex-1 truncate px-4 py-1.5 text-sm"},ue={href:"#",class:"font-semibold text-lg text-gray-900 hover:text-gray-600"},me=e("p",{class:"-mt-1 text-gray-500 text-sm"},"Sites",-1),_e={class:"relative col-span-1 flex rounded-md shadow-sm"},fe={class:h(["bg-blue-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md"])},he={class:"flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white"},ye={class:"flex-1 truncate px-4 py-1.5 text-sm"},xe={href:"#",class:"font-semibold text-lg text-gray-900 hover:text-gray-600"},ge=e("p",{class:"-mt-1 text-gray-500 text-sm"},"Households",-1),ve={class:"relative col-span-1 flex rounded-md shadow-sm"},be={class:h(["bg-yellow-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md"])},we={class:"flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white"},ke={class:"flex-1 truncate px-4 py-1.5 text-sm"},Ce={href:"#",class:"font-semibold text-lg text-gray-900 hover:text-gray-600"},De=e("p",{class:"-mt-1 text-gray-500 text-sm"},"Population",-1),je={class:"relative col-span-1 flex rounded-md shadow-sm"},Te={class:h(["bg-green-600 flex-shrink-0 flex items-center justify-center w-16 text-white text-sm font-medium rounded-l-md"])},Re={class:"flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white"},Ie={class:"flex-1 truncate px-4 py-1.5 text-sm"},ze={href:"#",class:"font-semibold text-lg text-gray-900 hover:text-gray-600"},Ae=e("p",{class:"-mt-1 text-gray-500 text-sm"},"Applications",-1),Pe={class:"mt-10 px-4 sm:px-6 lg:px-8"},Ue={class:"grid grid-cols-7 gap-3"},Le={class:"col-span-4"},Se=e("h2",{class:"text-sm font-medium text-gray-900"},"Follow Ups",-1),Ve={class:"mt-2"},Ne={class:"col-span-3"},Oe=e("h2",{class:"text-sm font-medium text-gray-900"},"Applications",-1),Be={class:"mt-2"},Ge=e("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),He={class:"fixed inset-0 z-10 overflow-y-auto"},Me={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},Fe={class:"bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4"},Ye={class:"flex justify-between items-center"},Ee=e("div",{class:"mt-1"},[e("p",{class:"text-sm text-gray-500"},"Select an user to check daily report")],-1),Xe={class:"my-5 flex flex-col gap-y-6"},qe={class:""},Je=e("option",{value:"",selected:"",disabled:""},"Select User",-1),Ke=["value"],Qe={key:0,class:"mt-1 text-red-600 text-sm"},We={class:"bg-gray-50 px-4 gap-3 py-3 sm:flex sm:flex-row-reverse sm:px-6"},Ze=e("span",null,"Check",-1),$e=[Ze],et={key:1,class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold bg-blue-600 opacity-60 text-white cursor-not-allowed"},tt=e("span",null,"Checking",-1),st=e("svg",{class:"animate-spin ml-3 h-5 w-5 text-white",xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"},[e("circle",{class:"opacity-25",cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}),e("path",{class:"opacity-75",fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"})],-1),ot=[tt,st],it=e("span",null,"Cancel",-1),rt=[it],lt=e("div",{class:"fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"},null,-1),at={class:"fixed inset-0 z-10 overflow-y-auto"},nt={class:"flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"},ct={class:"bg-white px-4 pt-5 pb-4 sm:p-6 sm:pt-5 sm:pb-4"},dt={class:"flex justify-between items-center"},pt={class:"mt-1"},ut={class:"text-sm text-gray-500"},mt={key:0,class:"mt-5"},_t={class:"overflow-hidden ring-1 ring-black ring-opacity-10 md:rounded-lg"},ft={class:"min-w-full divide-y divide-gray-300"},ht=e("thead",{class:"bg-gray-50"},[e("tr",null,[e("th",{scope:"col",class:"py-2 pl-4 pr-3 w-20 text-left text-sm font-semibold text-gray-900 sm:pl-6"},"Report"),e("th",{scope:"col",class:"px-3 py-2 text-right text-sm font-semibold text-gray-900"},"Today"),e("th",{scope:"col",class:"px-3 py-2 text-right text-sm font-semibold text-gray-900"},"Cumulative")])],-1),yt={class:"divide-y divide-gray-200 bg-white"},xt={class:"whitespace-nowrap py-2 pl-4 pr-3 w-20 text-sm sm:pl-6"},gt={class:"font-medium text-gray-900"},vt={class:"whitespace-nowrap text-right px-3 py-2 text-sm text-gray-500"},bt={class:"whitespace-nowrap text-right px-3 py-2 text-sm text-gray-500"},wt={class:"mr-5"},kt={class:"bg-gray-50 px-4 gap-3 py-3 sm:flex sm:flex-row-reverse sm:px-6"},Ct=e("span",null,"Close",-1),Dt=[Ct];function jt(u,o,c,m,t,p){const _=l("DocumentTextIcon"),T=l("MapPinIcon"),R=l("HomeIcon"),I=l("UserGroupIcon"),g=l("apexchart"),f=l("TransitionChild"),v=l("DialogTitle"),z=l("InputLabel"),b=l("DialogPanel"),w=l("Dialog"),k=l("TransitionRoot"),A=l("AppLayout");return n(),E(A,null,{default:r(()=>[e("div",ee,[e("div",te,[se,e("div",oe,[e("button",{onClick:o[0]||(o[0]=(...i)=>p.dailyReport&&p.dailyReport(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},[s(_,{class:"-ml-0.5 mr-2 h-5 w-5","aria-hidden":"true"}),ie])])]),e("div",re,[le,e("ul",ae,[e("li",ne,[e("div",ce,[s(T,{class:"h-7 w-7"})]),e("div",de,[e("div",pe,[e("a",ue,a(c.overview.sites),1),me])])]),e("li",_e,[e("div",fe,[s(R,{class:"h-7 w-7"})]),e("div",he,[e("div",ye,[e("a",xe,a(c.overview.households),1),ge])])]),e("li",ve,[e("div",be,[s(I,{class:"h-7 w-7"})]),e("div",we,[e("div",ke,[e("a",Ce,a(c.overview.population),1),De])])]),e("li",je,[e("div",Te,[s(_,{class:"h-7 w-7"})]),e("div",Re,[e("div",Ie,[e("a",ze,a(c.overview.applications),1),Ae])])])])]),e("div",Pe,[e("div",Ue,[e("div",Le,[Se,e("div",Ve,[s(g,{width:"100%",type:"bar",options:t.charts.followup.options,series:t.charts.followup.series},null,8,["options","series"])])]),e("div",Ne,[Oe,e("div",Be,[s(g,{width:"100%",type:"pie",options:t.charts.applications.options,series:t.charts.applications.series},null,8,["options","series"])])])])]),s(k,{as:"template",show:t.daily_report.show_popup},{default:r(()=>[s(w,{as:"div",class:"relative z-10",onClose:o[4]||(o[4]=i=>t.daily_report.show_popup=!1)},{default:r(()=>[s(f,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:r(()=>[Ge]),_:1}),e("div",He,[e("div",Me,[s(f,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:r(()=>[s(b,{class:"relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm"},{default:r(()=>[e("div",Fe,[e("div",Ye,[e("div",null,[s(v,{as:"h3",class:"text-lg font-medium leading-6 text-gray-900"},{default:r(()=>[C("Daily Report")]),_:1}),Ee])]),e("div",Xe,[e("div",qe,[s(z,{for:"daily_report_user",value:"User"}),X(e("select",{"onUpdate:modelValue":o[1]||(o[1]=i=>t.daily_report.user.value=i),id:"site_state",class:"mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm"},[Je,(n(!0),d(j,null,D(c.users,i=>(n(),d("option",{key:i.id,value:i.id},a(i.name),9,Ke))),128))],512),[[q,t.daily_report.user.value]]),t.daily_report.user.error?(n(),d("p",Qe,"Please select a user to check report")):x("",!0)])])]),e("div",We,[t.daily_report.processing?t.daily_report.processing?(n(),d("button",et,ot)):x("",!0):(n(),d("button",{key:0,onClick:o[2]||(o[2]=(...i)=>p.fetchDailyReport&&p.fetchDailyReport(...i)),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 bg-blue-600 text-white hover:text-slate-100 hover:bg-blue-500 active:bg-blue-800 active:text-blue-100 focus-visible:outline-blue-600"},$e)),e("button",{onClick:o[3]||(o[3]=i=>t.daily_report.show_popup=!1),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},rt)])]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"]),s(k,{as:"template",show:t.daily_report_viewer.show_popup},{default:r(()=>[s(w,{as:"div",class:"relative z-10",onClose:o[6]||(o[6]=i=>t.daily_report_viewer.show_popup=!1)},{default:r(()=>[s(f,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0","enter-to":"opacity-100",leave:"ease-in duration-200","leave-from":"opacity-100","leave-to":"opacity-0"},{default:r(()=>[lt]),_:1}),e("div",at,[e("div",nt,[s(f,{as:"template",enter:"ease-out duration-300","enter-from":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to":"opacity-100 translate-y-0 sm:scale-100",leave:"ease-in duration-200","leave-from":"opacity-100 translate-y-0 sm:scale-100","leave-to":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:r(()=>[s(b,{class:"relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"},{default:r(()=>[e("div",ct,[e("div",dt,[e("div",null,[s(v,{as:"h3",class:"text-lg font-medium leading-6 text-gray-900"},{default:r(()=>[C(a(t.daily_report_viewer.report.user.name),1)]),_:1}),e("div",pt,[e("p",ut,"This is the daily report of "+a(t.daily_report_viewer.report.user.name),1)])])]),t.daily_report_viewer.report!=null?(n(),d("div",mt,[e("div",_t,[e("table",ft,[ht,e("tbody",yt,[(n(!0),d(j,null,D(t.daily_report_viewer.report.names,(i,y)=>(n(),d("tr",{key:y},[e("td",xt,[e("div",null,[e("div",gt,a(i),1)])]),e("td",vt,a(t.daily_report_viewer.report.today[y]),1),e("td",bt,[e("div",wt,a(t.daily_report_viewer.report.cumulative[y]),1)])]))),128))])])])])):x("",!0)]),e("div",kt,[e("button",{onClick:o[5]||(o[5]=i=>t.daily_report_viewer.show_popup=!1),type:"button",class:"group inline-flex items-center justify-center rounded-full py-1.5 px-6 text-sm font-semibold focus:outline-none focus-visible:outline-2 focus-visible:outline-offset-2 border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 active:bg-gray-100 focus-visible:outline-blue-600"},Dt)])]),_:1})]),_:1})])])]),_:1})]),_:1},8,["show"])])]),_:1})}const St=J($,[["render",jt]]);export{St as default};
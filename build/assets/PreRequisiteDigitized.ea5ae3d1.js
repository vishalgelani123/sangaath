import{A as y,a as v}from"./AppLayout.c471b81a.js";import{_ as w}from"./TextInput.86ba2c92.js";import{_ as k}from"./InputLabel.5855d489.js";import{V as D,r as L,a as z,b as A}from"./vue3-apexcharts.common.85077902.js";import{L as I,B as d,o as m,c as O,w as n,a as e,b as r,g as p,n as c,D as R,N as V,e as f,i as C,F as j,t as x}from"./app.c9482037.js";import{_ as B}from"./_plugin-vue_export-helper.cdc0426e.js";const S={components:{apexchart:D,AppLayout:y,TextInput:w,InputLabel:k,MapPinIcon:L,HomeIcon:v,UserGroupIcon:z,DocumentTextIcon:A,Link:I},props:["sites"],data(){return{filter:{site:"all"},chart:{household:{series:[],options:{chart:{type:"bar",height:400,stacked:!0,toolbar:{show:!1},zoom:{enabled:!1}},responsive:[{breakpoint:480,options:{legend:{position:"bottom",offsetX:-10,offsetY:0}}}],plotOptions:{bar:{horizontal:!1,borderRadius:2}},xaxis:{type:"category",categories:[],labels:{hideOverlappingLabels:!0}},legend:{position:"top",offsetY:0},fill:{opacity:1}}},member:{series:[],options:{chart:{type:"bar",height:400,stacked:!0,toolbar:{show:!1},zoom:{enabled:!1}},responsive:[{breakpoint:480,options:{legend:{position:"bottom",offsetX:-10,offsetY:0}}}],plotOptions:{bar:{horizontal:!1,borderRadius:2}},xaxis:{type:"category",categories:[],labels:{hideOverlappingLabels:!0}},legend:{position:"top",offsetY:0},fill:{opacity:1}}}}}},mounted(){this.getData()},methods:{getData(){var h=this.filter.site,a=new FormData;a.append("site_id",h);var s=this;axios.post("/charts/prerequisite-digitized",a).then(function(u){var t=u.data;if(t.status==1){var i=t.data;s.chart.household.series=[{name:"Digitized",data:Object.values(i.report.household)}],s.chart.household.options={...s.chart.household.options,xaxis:{categories:Object.keys(i.report.household)}},s.chart.member.series=[{name:"Digitized",data:Object.values(i.report.member)}],s.chart.member.options={...s.chart.member.options,xaxis:{categories:Object.keys(i.report.member)}}}})}}},W={class:"flex-1"},F={class:"flex items-center justify-between"},N={class:"w-full border-b border-gray-200"},P={class:"-mb-px flex","aria-label":"Tabs"},T={class:"mt-6 px-4 sm:px-6 lg:px-8"},Y={class:"max-w-sm"},q=e("option",{value:"all"},"All Sites",-1),M=["value"],H={class:"mt-10"},U=e("h2",{class:"text-sm font-medium text-gray-900"},"Household Wise Report",-1),X={class:"mt-2"},E={class:"mt-5"},G=e("h2",{class:"text-sm font-medium text-gray-900"},"Member Wise Report",-1),J={class:"mt-2"};function K(h,a,s,u,t,i){const l=d("Link"),g=d("InputLabel"),b=d("apexchart"),_=d("AppLayout");return m(),O(_,null,{default:n(()=>[e("div",W,[e("div",F,[e("div",N,[e("nav",P,[r(l,{href:"/charts/village-wise-applications",class:c(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:n(()=>[p(" Village Wise Applications ")]),_:1}),r(l,{href:"/charts/scheme-wise-applications",class:c(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:n(()=>[p(" Scheme Wise Applications ")]),_:1}),r(l,{href:"/charts/prd-wise-applications",class:c(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:n(()=>[p(" PRD Wise Applications ")]),_:1}),r(l,{href:"/charts/card-disbursement",class:c(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:n(()=>[p(" Card Disbursement ")]),_:1}),r(l,{class:c(["border-blue-500 text-blue-600","w-1/5 py-4 px-1 text-center border-b-2 font-semibold text-sm"]),"aria-current":"page"},{default:n(()=>[p(" Pre-Requisite Digitized ")]),_:1})])])]),e("div",T,[e("div",Y,[r(g,{for:"village_site",value:"Filter by Site"}),R(e("select",{"onUpdate:modelValue":a[0]||(a[0]=o=>t.filter.site=o),onChange:a[1]||(a[1]=(...o)=>i.getData&&i.getData(...o)),id:"filter_site",class:"mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm"},[q,(m(!0),f(j,null,C(s.sites,o=>(m(),f("option",{key:o.id,value:o.id},x(o.name)+" ("+x(o.display_state)+") ",9,M))),128))],544),[[V,t.filter.site]])]),e("div",H,[U,e("div",X,[r(b,{width:"100%",height:"500px",type:"bar",options:t.chart.household.options,series:t.chart.household.series},null,8,["options","series"])])]),e("div",E,[G,e("div",J,[r(b,{width:"100%",height:"500px",type:"bar",options:t.chart.member.options,series:t.chart.member.series},null,8,["options","series"])])])])])]),_:1})}const oe=B(S,[["render",K]]);export{oe as default};

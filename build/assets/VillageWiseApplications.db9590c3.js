import{A as y,a as v}from"./AppLayout.c471b81a.js";import{_ as w}from"./TextInput.86ba2c92.js";import{_ as D}from"./InputLabel.5855d489.js";import{V as L,r as k,a as A,b as I}from"./vue3-apexcharts.common.85077902.js";import{L as V,B as d,o as m,c as C,w as i,a as e,b as s,g as p,n as c,D as z,N as B,e as b,i as S,F,t as x}from"./app.c9482037.js";import{_ as N}from"./_plugin-vue_export-helper.cdc0426e.js";const T={components:{apexchart:L,AppLayout:y,TextInput:w,InputLabel:D,MapPinIcon:k,HomeIcon:v,UserGroupIcon:A,DocumentTextIcon:I,Link:V},props:["sites"],data(){return{filter:{site:"all"},chart:{series:[],options:{chart:{type:"bar",height:400,stacked:!0,toolbar:{show:!1},zoom:{enabled:!1}},responsive:[{breakpoint:480,options:{legend:{position:"bottom",offsetX:-10,offsetY:0}}}],plotOptions:{bar:{horizontal:!1,borderRadius:2}},xaxis:{type:"string",categories:[]},legend:{position:"top",offsetY:0},fill:{opacity:1}}}}},mounted(){this.getData()},methods:{getData(){var u=this.filter.site,r=new FormData;r.append("site_id",u);var n=this;axios.post("/charts/village-wise-applications",r).then(function(f){var a=f.data;if(a.status==1){var o=a.data;n.chart.series=[{name:"Complete",data:Object.values(o.confirm_applications)},{name:"Incomplete",data:Object.values(o.incomplete_forms)}],n.chart.options={...n.chart.options,xaxis:{categories:o.village_names}}}})}}},W={class:"flex-1"},j={class:"flex items-center justify-between"},O={class:"w-full border-b border-gray-200"},P={class:"-mb-px flex","aria-label":"Tabs"},R={class:"mt-6 px-4 sm:px-6 lg:px-8"},q={class:"max-w-sm"},M=e("option",{value:"all"},"All Sites",-1),U=["value"],Y={class:"mt-10"};function $(u,r,n,f,a,o){const l=d("Link"),h=d("InputLabel"),_=d("apexchart"),g=d("AppLayout");return m(),C(g,null,{default:i(()=>[e("div",W,[e("div",j,[e("div",O,[e("nav",P,[s(l,{class:c(["border-blue-500 text-blue-600","w-1/5 py-4 px-1 text-center border-b-2 font-semibold text-sm"]),"aria-current":"page"},{default:i(()=>[p(" Village Wise Applications ")]),_:1}),s(l,{href:"/charts/scheme-wise-applications",class:c(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:i(()=>[p(" Scheme Wise Applications ")]),_:1}),s(l,{href:"/charts/prd-wise-applications",class:c(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:i(()=>[p(" PRD Wise Applications ")]),_:1}),s(l,{href:"/charts/card-disbursement",class:c(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:i(()=>[p(" Card Disbursement ")]),_:1}),s(l,{href:"/charts/prerequisite-digitized",class:c(["border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300","w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm"]),"aria-current":"page"},{default:i(()=>[p(" Pre-Requisite Digitized ")]),_:1})])])]),e("div",R,[e("div",q,[s(h,{for:"village_site",value:"Filter by Site"}),z(e("select",{"onUpdate:modelValue":r[0]||(r[0]=t=>a.filter.site=t),onChange:r[1]||(r[1]=(...t)=>o.getData&&o.getData(...t)),id:"filter_site",class:"mt-1 block w-full rounded-md border border-gray-200 font-medium bg-gray-50 px-3 py-2 text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-blue-500 sm:text-sm"},[M,(m(!0),b(F,null,S(n.sites,t=>(m(),b("option",{key:t.id,value:t.id},x(t.name)+" ("+x(t.display_state)+") ",9,U))),128))],544),[[B,a.filter.site]])]),e("div",Y,[s(_,{width:"100%",height:"500px",type:"bar",options:a.chart.options,series:a.chart.series},null,8,["options","series"])])])])]),_:1})}const Q=N(T,[["render",$]]);export{Q as default};

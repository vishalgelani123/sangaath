import{P as F,O as I,p as L,t as V,c as K,d as _,e as $,V as j,w as x,S as le,h as M,g as y,m as S,i as A,M as h,j as w}from"./AppLayout.c471b81a.js";import{K as B,d as U,e as W,P as z,p as H}from"./switch.67ed66d7.js";import{x as C,d as O,v as i,Q as c,k as G,F as J,m as Q,z as q,l as X,p as Y}from"./app.c9482037.js";function Z(a,p){return a===p}let N=Symbol("RadioGroupContext");function T(a){let p=X(N,null);if(p===null){let m=new Error(`<${a} /> is missing a parent <RadioGroup /> component.`);throw Error.captureStackTrace&&Error.captureStackTrace(m,T),m}return p}let oe=C({name:"RadioGroup",emits:{"update:modelValue":a=>!0},props:{as:{type:[Object,String],default:"div"},disabled:{type:[Boolean],default:!1},by:{type:[String,Function],default:()=>Z},modelValue:{type:[Object,String,Number,Boolean],default:void 0},defaultValue:{type:[Object,String,Number,Boolean],default:void 0},name:{type:String,optional:!0}},inheritAttrs:!1,setup(a,{emit:p,attrs:m,slots:E,expose:d}){let u=O(null),o=O([]),P=B({name:"RadioGroupLabel"}),f=F({name:"RadioGroupDescription"});d({el:u,$el:u});let[b,g]=U(i(()=>a.modelValue),e=>p("update:modelValue",e),i(()=>a.defaultValue)),s={options:o,value:b,disabled:i(()=>a.disabled),firstOption:i(()=>o.value.find(e=>!e.propsRef.disabled)),containsCheckedOption:i(()=>o.value.some(e=>s.compare(c(e.propsRef.value),c(a.modelValue)))),compare(e,t){if(typeof a.by=="string"){let l=a.by;return(e==null?void 0:e[l])===(t==null?void 0:t[l])}return a.by(e,t)},change(e){var t;if(a.disabled||s.compare(c(b.value),c(e)))return!1;let l=(t=o.value.find(n=>s.compare(c(n.propsRef.value),c(e))))==null?void 0:t.propsRef;return l!=null&&l.disabled?!1:(g(e),!0)},registerOption(e){o.value.push(e),o.value=I(o.value,t=>t.element)},unregisterOption(e){let t=o.value.findIndex(l=>l.id===e);t!==-1&&o.value.splice(t,1)}};Y(N,s),L({container:i(()=>M(u)),accept(e){return e.getAttribute("role")==="radio"?NodeFilter.FILTER_REJECT:e.hasAttribute("role")?NodeFilter.FILTER_SKIP:NodeFilter.FILTER_ACCEPT},walk(e){e.setAttribute("role","none")}});function v(e){if(!u.value||!u.value.contains(e.target))return;let t=o.value.filter(l=>l.propsRef.disabled===!1).map(l=>l.element);switch(e.key){case y.Enter:H(e.currentTarget);break;case y.ArrowLeft:case y.ArrowUp:if(e.preventDefault(),e.stopPropagation(),A(t,h.Previous|h.WrapAround)===w.Success){let l=o.value.find(n=>{var r;return n.element===((r=S(u))==null?void 0:r.activeElement)});l&&s.change(l.propsRef.value)}break;case y.ArrowRight:case y.ArrowDown:if(e.preventDefault(),e.stopPropagation(),A(t,h.Next|h.WrapAround)===w.Success){let l=o.value.find(n=>{var r;return n.element===((r=S(n.element))==null?void 0:r.activeElement)});l&&s.change(l.propsRef.value)}break;case y.Space:{e.preventDefault(),e.stopPropagation();let l=o.value.find(n=>{var r;return n.element===((r=S(n.element))==null?void 0:r.activeElement)});l&&s.change(l.propsRef.value)}break}}let R=`headlessui-radiogroup-${V()}`;return()=>{let{disabled:e,name:t,...l}=a,n={ref:u,id:R,role:"radiogroup","aria-labelledby":P.value,"aria-describedby":f.value,onKeydown:v};return G(J,[...t!=null&&b.value!=null?W({[t]:b.value}).map(([r,k])=>G(K,_({features:$.Hidden,key:r,as:"input",type:"hidden",hidden:!0,readOnly:!0,name:r,value:k}))):[],j({ourProps:n,theirProps:{...m,...x(l,["modelValue","defaultValue"])},slot:{},attrs:m,slots:E,name:"RadioGroup"})])}}});var ee=(a=>(a[a.Empty=1]="Empty",a[a.Active=2]="Active",a))(ee||{});let ne=C({name:"RadioGroupOption",props:{as:{type:[Object,String],default:"div"},value:{type:[Object,String,Number,Boolean]},disabled:{type:Boolean,default:!1}},setup(a,{attrs:p,slots:m,expose:E}){let d=T("RadioGroupOption"),u=`headlessui-radiogroup-option-${V()}`,o=B({name:"RadioGroupLabel"}),P=F({name:"RadioGroupDescription"}),f=O(null),b=i(()=>({value:a.value,disabled:a.disabled})),g=O(1);E({el:f,$el:f}),Q(()=>d.registerOption({id:u,element:f,propsRef:b})),q(()=>d.unregisterOption(u));let s=i(()=>{var r;return((r=d.firstOption.value)==null?void 0:r.id)===u}),v=i(()=>d.disabled.value||a.disabled),R=i(()=>d.compare(c(d.value.value),c(a.value))),e=i(()=>v.value?-1:R.value||!d.containsCheckedOption.value&&s.value?0:-1);function t(){var r;!d.change(a.value)||(g.value|=2,(r=f.value)==null||r.focus())}function l(){g.value|=2}function n(){g.value&=-3}return()=>{let r=x(a,["value","disabled"]),k={checked:R.value,disabled:v.value,active:Boolean(g.value&2)},D={id:u,ref:f,role:"radio","aria-checked":R.value?"true":"false","aria-labelledby":o.value,"aria-describedby":P.value,"aria-disabled":v.value?!0:void 0,tabIndex:e.value,onClick:v.value?void 0:t,onFocus:v.value?void 0:l,onBlur:v.value?void 0:n};return j({ourProps:D,theirProps:r,slot:k,attrs:p,slots:m,name:"RadioGroupOption"})}}}),ue=z;export{ue as O,ne as g,oe as y};
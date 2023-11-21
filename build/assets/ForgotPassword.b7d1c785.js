import{u,o as l,e as m,b as s,h as a,w as o,F as c,K as f,t as _,f as p,a as t,n as w,g,I as b}from"./app.c9482037.js";import{A as y}from"./AuthenticationCard.625d391e.js";import{_ as h}from"./AuthenticationCardLogo.7da04e80.js";import{_ as x}from"./InputError.7b5bc181.js";import{_ as k}from"./InputLabel.5855d489.js";import{_ as V}from"./PrimaryButton.8e8418c9.js";import{_ as v}from"./TextInput.86ba2c92.js";import"./_plugin-vue_export-helper.cdc0426e.js";const F=t("div",{class:"mb-4 text-sm text-gray-600"}," Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one. ",-1),N={key:0,class:"mb-4 font-medium text-sm text-green-600"},$=["onSubmit"],C={class:"flex items-center justify-end mt-4"},H={__name:"ForgotPassword",props:{status:String},setup(r){const e=u({email:""}),n=()=>{e.post(route("password.email"))};return(S,i)=>(l(),m(c,null,[s(a(f),{title:"Forgot Password"}),s(y,null,{logo:o(()=>[s(h)]),default:o(()=>[F,r.status?(l(),m("div",N,_(r.status),1)):p("",!0),t("form",{onSubmit:b(n,["prevent"])},[t("div",null,[s(k,{for:"email",value:"Email"}),s(v,{id:"email",modelValue:a(e).email,"onUpdate:modelValue":i[0]||(i[0]=d=>a(e).email=d),type:"email",class:"mt-1 block w-full",required:"",autofocus:""},null,8,["modelValue"]),s(x,{class:"mt-2",message:a(e).errors.email},null,8,["message"])]),t("div",C,[s(V,{class:w({"opacity-25":a(e).processing}),disabled:a(e).processing},{default:o(()=>[g(" Email Password Reset Link ")]),_:1},8,["class","disabled"])])],40,$)]),_:1})],64))}};export{H as default};

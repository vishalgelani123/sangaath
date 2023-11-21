import{u as l,d,o as c,e as u,b as o,h as e,w as r,F as p,K as f,a,n as _,g as w,I as b}from"./app.c9482037.js";import{A as g}from"./AuthenticationCard.625d391e.js";import{_ as h}from"./AuthenticationCardLogo.7da04e80.js";import{_ as x}from"./InputError.7b5bc181.js";import{_ as v}from"./InputLabel.5855d489.js";import{_ as y}from"./PrimaryButton.8e8418c9.js";import{_ as V}from"./TextInput.86ba2c92.js";import"./_plugin-vue_export-helper.cdc0426e.js";const C=a("div",{class:"mb-4 text-sm text-gray-600"}," This is a secure area of the application. Please confirm your password before continuing. ",-1),$=["onSubmit"],k={class:"flex justify-end mt-4"},z={__name:"ConfirmPassword",setup(F){const s=l({password:""}),t=d(null),n=()=>{s.post(route("password.confirm"),{onFinish:()=>{s.reset(),t.value.focus()}})};return(A,i)=>(c(),u(p,null,[o(e(f),{title:"Secure Area"}),o(g,null,{logo:r(()=>[o(h)]),default:r(()=>[C,a("form",{onSubmit:b(n,["prevent"])},[a("div",null,[o(v,{for:"password",value:"Password"}),o(V,{id:"password",ref_key:"passwordInput",ref:t,modelValue:e(s).password,"onUpdate:modelValue":i[0]||(i[0]=m=>e(s).password=m),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"current-password",autofocus:""},null,8,["modelValue"]),o(x,{class:"mt-2",message:e(s).errors.password},null,8,["message"])]),a("div",k,[o(y,{class:_(["ml-4",{"opacity-25":e(s).processing}]),disabled:e(s).processing},{default:r(()=>[w(" Confirm ")]),_:1},8,["class","disabled"])])],40,$)]),_:1})],64))}};export{z as default};

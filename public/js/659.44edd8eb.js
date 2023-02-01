"use strict";(globalThis["webpackChunkrentacarpanel"]=globalThis["webpackChunkrentacarpanel"]||[]).push([[659],{3659:(t,e,i)=>{i.r(e),i.d(e,{default:()=>L});var l=i(3673),s=i(2323);const a=t=>((0,l.dD)("data-v-1b1ae3f4"),t=t(),(0,l.Cn)(),t),o={class:"q-pa-md"},r=a((()=>(0,l._)("i",{class:"fas fa-edit"},null,-1))),n=a((()=>(0,l._)("i",{class:"fas fa-trash-alt"},null,-1))),d=a((()=>(0,l._)("div",{class:"text-h4"},"Yeni Şehir Oluştur",-1))),c={class:"row"},u={class:"col-4 q-pa-xs"},m=a((()=>(0,l._)("div",{class:"text-subtitle2 text-grey-8"}," Şehir Seçiniz ",-1))),p={class:"col-4 q-pa-xs"},g=a((()=>(0,l._)("div",{class:"text-subtitle2 text-grey-8"}," Şehir Adı ",-1))),h={class:"col-4 q-pa-xs"},f=a((()=>(0,l._)("div",{class:"text-subtitle2 text-grey-8"}," Şehir Statusu",-1))),w={class:"row q-mt-xs"},b={class:"col-12"},y=a((()=>(0,l._)("div",{class:"text-subtitle2 text-grey-8"}," Harita Konumu ",-1))),_={class:"row"},S={class:"col-12"},F={class:"row"},v={key:0,class:"col-12 text-right"},D={key:1,class:"col-12 text-right"};function k(t,e,i,a,k,q){const x=(0,l.up)("q-icon"),C=(0,l.up)("q-input"),W=(0,l.up)("q-btn"),N=(0,l.up)("q-td"),Z=(0,l.up)("q-chip"),Q=(0,l.up)("q-tr"),H=(0,l.up)("q-table"),M=(0,l.up)("q-space"),P=(0,l.up)("q-tooltip"),U=(0,l.up)("q-bar"),V=(0,l.up)("q-select"),z=(0,l.up)("GMapAutocomplete"),B=(0,l.up)("q-toggle"),T=(0,l.up)("GMapMarker"),$=(0,l.up)("GMapCluster"),A=(0,l.up)("GMapMap"),I=(0,l.up)("q-form"),K=(0,l.up)("q-card-section"),O=(0,l.up)("q-card"),R=(0,l.up)("q-dialog"),E=(0,l.Q2)("close-popup");return(0,l.wg)(),(0,l.iD)("div",o,[(0,l.Wm)(H,{title:"Ofis Bölgeleri",rows:q.districtRows,columns:a.baseSetting.districtColumns,"row-key":"id",filter:a.baseSetting.filter},{"top-right":(0,l.w5)((()=>[(0,l.Wm)(C,{outlined:"",dense:"",debounce:"300",color:"primary",modelValue:a.baseSetting.filter,"onUpdate:modelValue":e[0]||(e[0]=t=>a.baseSetting.filter=t),placeholder:"Bölge Arayınız..."},{append:(0,l.w5)((()=>[(0,l.Wm)(x,{name:"search"})])),_:1},8,["modelValue"]),(0,l.Wm)(W,{color:"primary",label:"Yeni Kayıt ",icon:"add",class:"q-mr-xs q-ml-xs q-pa-sm q-pr-md",onClick:e[1]||(e[1]=t=>a.baseSetting.showFormDialog=!0),ref:"showFormDialog",id:"showFormDialog"},null,512),(0,l.Wm)(W,{color:"blue-grey-8",icon:"archive",label:"Excel Oluştur",class:"q-pa-sm",disable:""})])),body:(0,l.w5)((t=>[((0,l.wg)(),(0,l.j4)(Q,{props:t,key:t.row.index,class:"text-center"},{default:(0,l.w5)((()=>[(0,l.Wm)(N,null,{default:(0,l.w5)((()=>[(0,l.Uk)((0,s.zw)({...this.$store.getters["Cities/elById"](t.row.city_id)}.CityName),1)])),_:2},1024),(0,l.Wm)(N,null,{default:(0,l.w5)((()=>[(0,l.Uk)((0,s.zw)(t.row.DistrictName),1)])),_:2},1024),(0,l.Wm)(N,null,{default:(0,l.w5)((()=>[(0,l.Wm)(Z,{square:"",color:1===+t.row.Status?"positive":"negative","text-color":"white",icon:1===+t.row.Status?"done":"clear",size:"13px"},{default:(0,l.w5)((()=>[(0,l.Uk)((0,s.zw)(1===+t.row.Status?"Açık":"Kapalı"),1)])),_:2},1032,["color","icon"])])),_:2},1024),(0,l.Wm)(N,null,{default:(0,l.w5)((()=>[(0,l.Uk)((0,s.zw)(a.baseSetting.dateFormat(t.row.created_at)),1)])),_:2},1024),(0,l.Wm)(N,{class:"text-right"},{default:(0,l.w5)((()=>[(0,l.Wm)(W,{flat:"",round:"",color:"blue-grey-9",onClick:e=>q.onEdit(t.row.id)},{default:(0,l.w5)((()=>[r])),_:2},1032,["onClick"]),(0,l.Wm)(W,{flat:"",round:"",color:"primary",disable:""},{default:(0,l.w5)((()=>[n])),_:1})])),_:2},1024)])),_:2},1032,["props"]))])),_:1},8,["rows","columns","filter"]),(0,l.Wm)(R,{modelValue:a.baseSetting.showFormDialog,"onUpdate:modelValue":e[4]||(e[4]=t=>a.baseSetting.showFormDialog=t),persistent:"",style:{"z-index":"999!important"}},{default:(0,l.w5)((()=>[(0,l.Wm)(O,{style:{"min-width":"700px"}},{default:(0,l.w5)((()=>[(0,l.Wm)(U,{class:"q-pa-md",style:{height:"50px"}},{default:(0,l.w5)((()=>[d,(0,l.Wm)(M),(0,l.wy)(((0,l.wg)(),(0,l.j4)(W,{dense:"",flat:"",icon:"close"},{default:(0,l.w5)((()=>[(0,l.Wm)(P,null,{default:(0,l.w5)((()=>[(0,l.Uk)("Kapat")])),_:1})])),_:1})),[[E]])])),_:1}),(0,l.Wm)(K,null,{default:(0,l.w5)((()=>[(0,l.Wm)(I,{onSubmit:q.onSubmit,class:"q-gutter-md"},{default:(0,l.w5)((()=>[(0,l._)("div",c,[(0,l._)("div",u,[m,(0,l.Wm)(V,{modelValue:a.formFields.city_id,"onUpdate:modelValue":e[2]||(e[2]=t=>a.formFields.city_id=t),options:q.cities,"option-label":t=>t.CityName,"option-value":t=>t.id,"lazy-rules":!0,rules:[t=>t&&t.CityName.length>0||"Zorunlu alan"],outlined:"",dense:"","hide-bottom-space":""},null,8,["modelValue","options","option-label","option-value","rules"])]),(0,l._)("div",p,[g,(0,l.Wm)(z,{placeholder:"Konum Arayınız",onPlace_changed:q.setPlace,class:"autoCompleteInput"},null,8,["onPlace_changed"])]),(0,l._)("div",h,[f,(0,l.Wm)(B,{modelValue:a.formFields.Status,"onUpdate:modelValue":e[3]||(e[3]=t=>a.formFields.Status=t),label:"Model Statusu",color:"green"},null,8,["modelValue"])])]),(0,l._)("div",w,[(0,l._)("div",b,[y,(0,l.Wm)(C,{outlined:"",dense:"","model-value":a.center.lat.toFixed(4)+" - "+a.center.lng.toFixed(4),"hide-bottom-space":"",readonly:"",for:"latLng"},null,8,["model-value"])])]),(0,l._)("div",_,[(0,l._)("div",S,[(0,l.Wm)(A,{center:a.center,zoom:9,"map-type-id":"terrain",style:{width:"500px",height:"300px!important"},disableDefaultUI:!0},{default:(0,l.w5)((()=>[(0,l.Wm)($,null,{default:(0,l.w5)((()=>[((0,l.wg)(!0),(0,l.iD)(l.HY,null,(0,l.Ko)(a.markers,((t,e)=>((0,l.wg)(),(0,l.j4)(T,{key:e,position:t.position,clickable:!1,draggable:!1,onClick:e=>a.center=t.position},null,8,["position","onClick"])))),128))])),_:1})])),_:1},8,["center"])])]),(0,l._)("div",F,[a.formFields.id?((0,l.wg)(),(0,l.iD)("div",D,[(0,l.Wm)(W,{label:"Güncelle",type:"button",color:"blue-grey-8","icon-right":"restart_alt",onClick:q.onUpdate},null,8,["onClick"])])):((0,l.wg)(),(0,l.iD)("div",v,[(0,l.Wm)(W,{label:"Sıfırla",type:"reset",color:"primary",flat:"",class:"q-ml-sm"}),(0,l.Wm)(W,{label:"Kaydet",type:"submit",color:"blue-grey-8","icon-right":"save"})]))])])),_:1},8,["onSubmit"])])),_:1})])),_:1})])),_:1},8,["modelValue"])])}const q=[{name:"CityName",align:"center",label:"Şehir Adı",field:"CityName",sortable:!0},{name:"DistrictName",align:"center",label:"Bölge Adı",field:"DistrictName",sortable:!0},{name:"Status",align:"center",label:"Statusu",field:"Status",sortable:!0},{name:"created_at",align:"center",label:"Tarih",field:"created_at"},{name:"id",align:"center",label:"",field:"id"}],x=q;var C=i(1959),W=i(4147);const N={name:"States",setup(){return{center:(0,C.iH)({lat:35.1937,lng:33.357}),markers:(0,C.iH)([{position:{lat:35.1937,lng:33.357}}]),map:(0,C.iH)(null),baseSetting:(0,C.iH)({dateFormat:W.v,showFormDialog:(0,C.iH)(!1),districtColumns:x,filter:(0,C.iH)("")}),formFields:(0,C.iH)({Status:(0,C.iH)(!0),DistrictName:(0,C.iH)(""),Positions:(0,C.iH)(""),city_id:(0,C.iH)(""),id:(0,C.iH)("")})}},mounted(){this.$store.dispatch("Cities/get"),this.$store.dispatch("DistrictModule/get")},computed:{cities(){return this.$store.getters["Cities/cities"]},districtRows(){return this.$store.getters["DistrictModule/getRecords"]}},methods:{onSubmit(){let t=new FormData;t.append("DistrictName",document.getElementsByClassName("pac-target-input")[0].value),t.append("Status",this.formFields.Status),t.append("Positions",JSON.stringify(this.center)),t.append("city_id",this.formFields.city_id.id),this.$store.dispatch("DistrictModule/create",t).then((t=>{this.onReset(),this.baseSetting.showFormDialog=!1}))},setPlace(t){this.setMarker(t.geometry.location.lat(),t.geometry.location.lng())},setMarker(t,e){this.center={lat:t,lng:e},this.markers=[{position:{lat:t,lng:e}}]},onEdit(t){const e=this.districtRows.find((e=>+e.id===+t));this.formFields.Status=1===+e.Status,this.formFields.id=e.id,this.formFields.Positions=JSON.parse(e.Positions),this.formFields.DistrictName=e.DistrictName,this.formFields.city_id=this.$store.getters["Cities/elById"](+e.city_id);const i=JSON.parse(e.Positions);this.setMarker(i.lat,i.lng),this.markers=[{position:i}],this.baseSetting.showFormDialog=!0,setTimeout((()=>{document.getElementsByClassName("pac-target-input")[0].value=e.DistrictName}),500)},onUpdate(){let t=new FormData;t.append("DistrictName",document.getElementsByClassName("pac-target-input")[0].value),t.append("city_id",this.formFields.city_id.id),t.append("Status",this.formFields.Status),t.append("id",this.formFields.id),t.append("Positions",JSON.stringify(this.center)),t.append("_method","PUT"),this.$store.dispatch("DistrictModule/update",t).then((t=>{this.onReset(),this.baseSetting.showFormDialog=!1}))},onReset(){this.formFields.DistrictName="",this.formFields.Positions="",this.formFields.city_id="",this.formFields.id="",this.formFields.Status=!0}}};var Z=i(4260),Q=i(4993),H=i(4689),M=i(4554),P=i(2165),U=i(8186),V=i(3884),z=i(7030),B=i(4390),T=i(151),$=i(846),A=i(2025),I=i(8870),K=i(5589),O=i(5269),R=i(3314),E=i(8886),G=i(677),J=i(7518),j=i.n(J);const Y=(0,Z.Z)(N,[["render",k],["__scopeId","data-v-1b1ae3f4"]]),L=Y;j()(N,"components",{QTable:Q.Z,QInput:H.Z,QIcon:M.Z,QBtn:P.Z,QTr:U.Z,QTd:V.Z,QChip:z.Z,QDialog:B.Z,QCard:T.Z,QBar:$.Z,QSpace:A.Z,QTooltip:I.Z,QCardSection:K.Z,QForm:O.Z,QSelect:R.Z,QToggle:E.Z}),j()(N,"directives",{ClosePopup:G.Z})}}]);
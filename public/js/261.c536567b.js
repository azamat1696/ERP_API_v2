"use strict";(globalThis["webpackChunkrentacarpanel"]=globalThis["webpackChunkrentacarpanel"]||[]).push([[261],{8261:(e,t,a)=>{a.r(t),a.d(t,{default:()=>ze});var i=a(3673),l=a(2323);const o={class:"q-pa-md"},s={class:"text-subtitle1 text-bold text-grey-9"},r={class:"text-subtitle1 text-blue-8"},n=(0,i._)("br",null,null,-1),d=(0,i._)("div",null,"Rezervasyon Durumunu Yönet",-1),u={class:"row"},c={class:"col-6 q-pa-xs"},m=(0,i._)("div",{class:"text-subtitle2 text-grey-8"},"Rezervasyon Statusu",-1),p={class:"col-6 q-pa-xs"},v=(0,i._)("div",{class:"text-subtitle2 text-grey-8"},"Ödeme Durumu",-1),b={class:"row q-mt-md"},g={class:"col-12 text-right"},w=(0,i._)("div",null,"Rezervasyon Evrak Yönetimi",-1),f={class:"row bg-grey-2 q-pl-md q-pr-md"},_={class:"col-12 q-pb-xs"},h=(0,i._)("div",{class:"text-subtitle2 text-bold"},"Fatura Bilgileri",-1),y={class:"col-1 flex flex-center"},x={class:"col-4 q-pl-sm"},W=(0,i._)("div",{class:"text-subtitle1 text-left"}," Fatura",-1),R={class:"text-subtitle2 text-left text-bold",style:{"margin-top":"-5px"}},N={class:"col-7 text-right"},k={class:"row q-mt-sm bg-grey-2 q-pl-md q-pr-md"},F={class:"col-12 q-pb-xs"},S=(0,i._)("div",{class:"text-subtitle2 text-bold"},"Makbuz / Tahsilat Bilgileri",-1),M={class:"col-1 flex flex-center"},C={class:"col-5 q-pl-sm"},D=(0,i._)("div",{class:"text-subtitle1 text-left"}," Makbuz / Tahsilat",-1),U={class:"text-subtitle2 text-left text-bold",style:{"margin-top":"-5px"}},z={class:"col-6 text-right"},q={class:"row q-mt-sm bg-grey-2 q-pl-md q-pr-md"},I={class:"col-12 q-pb-xs"},V=(0,i._)("div",{class:"text-subtitle2 text-bold"},"Sözleşme Bilgileri",-1),P={class:"col-1 flex flex-center"},Z={class:"col-5 q-pl-sm"},T=(0,i._)("div",{class:"text-subtitle1 text-left"}," Sözleşme",-1),E={class:"text-subtitle2 text-left text-bold",style:{"margin-top":"-5px"}},$={class:"col-6 text-right"},Q=(0,i._)("div",null,"Fatura Numara Yenileme",-1),A=(0,i._)("div",{class:"row"},[(0,i._)("div",{class:"col-12"},[(0,i._)("div",{class:"text-subtitle2 text-bold text-grey-8"}," Fatura Numarası ")])],-1),L={class:"row"},B={class:"col-12"},O={class:"col-12 text-right"},H=(0,i._)("div",null,"Makbuz Numarasını Yenileme",-1),Y=(0,i._)("div",{class:"row"},[(0,i._)("div",{class:"col-12"},[(0,i._)("div",{class:"text-subtitle2 text-bold text-grey-8"}," Makbuz Numarası ")])],-1),j={class:"row"},K={class:"col-12"},G={class:"col-12 text-right"},J=(0,i._)("div",null,"Rezervasyon Numarasını Yenileme",-1),X=(0,i._)("div",{class:"row"},[(0,i._)("div",{class:"col-12"},[(0,i._)("div",{class:"text-subtitle2 text-bold text-grey-8"}," Rezervasyon Numarası ")])],-1),ee={class:"row"},te={class:"col-12"},ae={class:"col-12 text-right"};function ie(e,t,a,ie,le,oe){const se=(0,i.up)("q-btn"),re=(0,i.up)("q-icon"),ne=(0,i.up)("q-input"),de=(0,i.up)("q-td"),ue=(0,i.up)("q-chip"),ce=(0,i.up)("show-location"),me=(0,i.up)("vehicle"),pe=(0,i.up)("customer"),ve=(0,i.up)("payment"),be=(0,i.up)("q-tooltip"),ge=(0,i.up)("q-tr"),we=(0,i.up)("q-table"),fe=(0,i.up)("q-space"),_e=(0,i.up)("q-bar"),he=(0,i.up)("q-select"),ye=(0,i.up)("q-form"),xe=(0,i.up)("q-card-section"),We=(0,i.up)("q-card"),Re=(0,i.up)("q-dialog"),Ne=(0,i.up)("q-separator"),ke=(0,i.Q2)("close-popup");return(0,i.wg)(),(0,i.iD)("div",o,[(0,i.Wm)(we,{rows:oe.currentReservations,columns:ie.columns,"row-key":"id",filter:ie.filter,"filter-method":oe.currentReservationFilter},{"top-left":(0,i.w5)((()=>[(0,i._)("div",s,[(0,i.Wm)(se,{color:"blue-grey",flat:"",icon:"arrow_back",to:{name:"listReservations"}}),(0,i.Uk)(" Tamamlanan Rezervasyonlar")])])),"top-right":(0,i.w5)((()=>[(0,i.Wm)(ne,{outlined:"",dense:"",color:"primary",modelValue:ie.filter,"onUpdate:modelValue":t[0]||(t[0]=e=>ie.filter=e),class:"q-mr-sm",placeholder:"Araç,Müşteri,Office Arama yapınız...",style:{width:"300px!important"}},{append:(0,i.w5)((()=>[(0,i.Wm)(re,{name:"search"})])),_:1},8,["modelValue"]),(0,i.Wm)(se,{color:"blue-grey-8",icon:"archive",label:"Excel Oluştur",class:"q-pa-sm q-pr-md",onClick:t[1]||(t[1]=e=>this.$store.dispatch("Reservations/exportAllReservation"))})])),body:(0,i.w5)((e=>[((0,i.wg)(),(0,i.j4)(ge,{props:e,key:e.row.index,class:"text-center"},{default:(0,i.w5)((()=>[(0,i.Wm)(de,{"auto-width":""},{default:(0,i.w5)((()=>[(0,i._)("div",r,(0,l.zw)(e.row.id),1)])),_:2},1024),(0,i.Wm)(de,{class:"text-center","auto-width":""},{default:(0,i.w5)((()=>[(0,i.Wm)(ue,{square:"",color:oe.reservationStatusColor(e.row.ReservationStatus).color,"text-color":"white",icon:oe.reservationStatusColor(e.row.ReservationStatus).icon},{default:(0,i.w5)((()=>[(0,i.Uk)((0,l.zw)(oe.reservationsStatus(e.row.ReservationStatus)),1)])),_:2},1032,["color","icon"])])),_:2},1024),(0,i.Wm)(de,{class:"text-center"},{default:(0,i.w5)((()=>[(0,i.Wm)(ce,{key:"PickupLocation",date:e.row.StartDateTime,"office-name":e.row.PickupLocation},null,8,["date","office-name"])])),_:2},1024),(0,i.Wm)(de,null,{default:(0,i.w5)((()=>[(0,i.Wm)(ce,{key:"DropUpLocation",date:e.row.EndDateTime,"office-name":e.row.DropLocation},null,8,["date","office-name"])])),_:2},1024),(0,i.Wm)(de,null,{default:(0,i.w5)((()=>[(0,i.Wm)(me,{brand:e.row.BrandName,model:e.row.ModelName,licence_plate:e.row.LicencePlate,image:e.row.Image},null,8,["brand","model","licence_plate","image"])])),_:2},1024),(0,i.Wm)(de,{"auto-width":""},{default:(0,i.w5)((()=>[(0,i.Wm)(pe,{customer:e.row.CustomerNameSurname,type:e.row.CustomerType},null,8,["customer","type"])])),_:2},1024),(0,i.Wm)(de,{"auto-width":""},{default:(0,i.w5)((()=>[(0,i.Wm)(ve,{total:e.row.TotalPrice,payment_type:e.row.PaymentMethod,currency_sembol:e.row.CurrencySymbol},null,8,["total","payment_type","currency_sembol"])])),_:2},1024),(0,i.Wm)(de,{"auto-width":""},{default:(0,i.w5)((()=>[(0,i.Wm)(se,{flat:"",round:"",color:"blue-grey-9",icon:"fas fa-edit",size:"sm",disable:"",onClick:t=>oe.reservationUpdateHandleBtn(e.row.id,e.row.ReservationStatus,e.row.PaymentState)},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Rezervasyon durumunu yönet. ")])),_:1})])),_:2},1032,["onClick"]),(0,i.Wm)(se,{flat:"",round:"",color:"blue-grey-9",icon:"dashboard_customize",size:"md",onClick:t=>oe.invoiceManage(e.row.id)},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Rezervasyon Evrak Yönetimi."),n,(0,i.Uk)(" Fatura / Makbux / Tahsilat ")])),_:1})])),_:2},1032,["onClick"])])),_:2},1024)])),_:2},1032,["props"]))])),_:1},8,["rows","columns","filter","filter-method"]),(0,i.Wm)(Re,{modelValue:ie.reservationManageDialog,"onUpdate:modelValue":t[4]||(t[4]=e=>ie.reservationManageDialog=e),persistent:""},{default:(0,i.w5)((()=>[(0,i.Wm)(We,{style:{width:"500px"}},{default:(0,i.w5)((()=>[(0,i.Wm)(_e,{style:{height:"50px"}},{default:(0,i.w5)((()=>[d,(0,i.Wm)(fe),(0,i.wy)(((0,i.wg)(),(0,i.j4)(se,{dense:"",flat:"",icon:"close"},{default:(0,i.w5)((()=>[(0,i.Wm)(be,null,{default:(0,i.w5)((()=>[(0,i.Uk)("Kapat")])),_:1})])),_:1})),[[ke]])])),_:1}),(0,i.Wm)(xe,null,{default:(0,i.w5)((()=>[(0,i.Wm)(ye,{onSubmit:oe.onsubmitReservationStatus},{default:(0,i.w5)((()=>[(0,i._)("div",u,[(0,i._)("div",c,[m,(0,i.Wm)(he,{modelValue:ie.reservationFields.ReservationStatus,"onUpdate:modelValue":t[2]||(t[2]=e=>ie.reservationFields.ReservationStatus=e),options:oe.reservationStatus,"lazy-rules":!0,rules:[e=>e&&e.length>0||"Zorunlu alan"],"emit-value":"","map-options":"","option-label":"title","option-value":"code",outlined:"",dense:""},null,8,["modelValue","options","rules"])]),(0,i._)("div",p,[v,(0,i.Wm)(he,{modelValue:ie.reservationFields.PaymentState,"onUpdate:modelValue":t[3]||(t[3]=e=>ie.reservationFields.PaymentState=e),options:oe.reservationPaymentStates,"lazy-rules":!0,rules:[e=>e&&e.length>0||"Zorunlu alan"],"emit-value":"","map-options":"","option-label":"title","option-value":"code",outlined:"",dense:""},null,8,["modelValue","options","rules"])])]),(0,i._)("div",b,[(0,i._)("div",g,[(0,i.Wm)(se,{type:"submit",color:"blue-grey-8",icon:"save",label:"Kaydet"})])])])),_:1},8,["onSubmit"])])),_:1})])),_:1})])),_:1},8,["modelValue"]),(0,i.Wm)(Re,{modelValue:ie.invoiceManageDialog,"onUpdate:modelValue":t[17]||(t[17]=e=>ie.invoiceManageDialog=e),persistent:""},{default:(0,i.w5)((()=>[(0,i.Wm)(We,{style:{width:"600px"}},{default:(0,i.w5)((()=>[(0,i.Wm)(_e,{style:{height:"50px"}},{default:(0,i.w5)((()=>[w,(0,i.Wm)(fe),(0,i.wy)(((0,i.wg)(),(0,i.j4)(se,{dense:"",flat:"",icon:"close"},{default:(0,i.w5)((()=>[(0,i.Wm)(be,null,{default:(0,i.w5)((()=>[(0,i.Uk)("Kapat")])),_:1})])),_:1})),[[ke]])])),_:1}),(0,i.Wm)(xe,null,{default:(0,i.w5)((()=>[(0,i._)("div",f,[(0,i._)("div",_,[h,(0,i.Wm)(Ne,{color:"grey-5"})]),(0,i._)("div",y,[(0,i.Wm)(re,{name:"assignment",size:"lg",color:"blue-grey-6"})]),(0,i._)("div",x,[W,(0,i._)("div",R," **** - "+(0,l.zw)(ie.invoiceManageFields.InvoiceNo),1)]),(0,i._)("div",N,[(0,i.Wm)(se,{icon:"published_with_changes",color:"blue-grey-8",fab:"",flat:"",onClick:t[5]||(t[5]=e=>oe.editInvoiceNumber(ie.invoiceManageFields.InvoiceID,ie.invoiceManageFields.InvoiceNo))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Fatura Numarasını Yenile ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"mark_email_read",color:"blue-grey-8",fab:"",flat:"",onClick:t[6]||(t[6]=e=>this.$store.dispatch("Reservations/sendReservationInvoiceToMail",ie.invoiceManageFields.InvoiceID))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Müşteriye Mail Gönder ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"cloud_download",color:"blue-grey-8",fab:"",flat:"",onClick:t[7]||(t[7]=e=>this.$store.dispatch("Reservations/downloadInvoice",ie.invoiceManageFields.InvoiceID))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Fatura İndir ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"print",color:"blue-grey-8",fab:"",flat:"",onClick:t[8]||(t[8]=e=>this.$store.dispatch("Reservations/printInvoice",ie.invoiceManageFields.InvoiceID))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Fatura Yazdır ")])),_:1})])),_:1})])]),(0,i._)("div",k,[(0,i._)("div",F,[S,(0,i.Wm)(Ne,{color:"grey-5"})]),(0,i._)("div",M,[(0,i.Wm)(re,{name:"description",size:"lg",color:"blue-grey-6"})]),(0,i._)("div",C,[D,(0,i._)("div",U," **** - "+(0,l.zw)(ie.invoiceManageFields.ReceiptCollectionNo),1)]),(0,i._)("div",z,[(0,i.Wm)(se,{icon:"published_with_changes",color:"blue-grey-8",fab:"",flat:"",onClick:t[9]||(t[9]=e=>oe.editReceiptNumber(ie.invoiceManageFields.ReceiptID,ie.invoiceManageFields.ReceiptCollectionNo))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Makbuz Numarasını Yenile ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"mark_email_read",color:"blue-grey-8",fab:"",flat:"",onClick:t[10]||(t[10]=e=>this.$store.dispatch("Reservations/sendReservationReceiptToMail",ie.invoiceManageFields.ReceiptID))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Müşteriye Mail Gönder ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"cloud_download",color:"blue-grey-8",fab:"",flat:"",onClick:t[11]||(t[11]=e=>this.$store.dispatch("Reservations/downloadReceipt",ie.invoiceManageFields.ReceiptID))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Makbuz / Tahsilat PDF İndir ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"print",color:"blue-grey-8",fab:"",flat:"",onClick:t[12]||(t[12]=e=>this.$store.dispatch("Reservations/printReceipt",ie.invoiceManageFields.ReceiptID))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Makbuz / Tahsilat Yazdır ")])),_:1})])),_:1})])]),(0,i._)("div",q,[(0,i._)("div",I,[V,(0,i.Wm)(Ne,{color:"grey-5"})]),(0,i._)("div",P,[(0,i.Wm)(re,{name:"receipt_long",size:"lg",color:"blue-grey-6"})]),(0,i._)("div",Z,[T,(0,i._)("div",E," **** - "+(0,l.zw)(ie.invoiceManageFields.ReservationNo),1)]),(0,i._)("div",$,[(0,i.Wm)(se,{icon:"published_with_changes",color:"blue-grey-8",fab:"",flat:"",onClick:t[13]||(t[13]=e=>oe.editReservationNumber(ie.invoiceManageFields.id,ie.invoiceManageFields.ReservationNo))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Sözleşme Numarasını Yenile ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"mark_email_read",color:"blue-grey-8",fab:"",flat:"",onClick:t[14]||(t[14]=e=>this.$store.dispatch("Reservations/sendReservationAgreementToMail",ie.invoiceManageFields.id))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Müşteriye Mail Gönder ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"cloud_download",color:"blue-grey-8",fab:"",flat:"",onClick:t[15]||(t[15]=e=>this.$store.dispatch("Reservations/getReservationAgreement",ie.invoiceManageFields.id))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Makbuz / Tahsilat PDF İndir ")])),_:1})])),_:1}),(0,i.Wm)(se,{icon:"print",color:"blue-grey-8",fab:"",flat:"",onClick:t[16]||(t[16]=e=>this.$store.dispatch("Reservations/printAgreement",ie.invoiceManageFields.id))},{default:(0,i.w5)((()=>[(0,i.Wm)(be,{class:"bg-blue-grey-8 text-white"},{default:(0,i.w5)((()=>[(0,i.Uk)(" Makbuz / Tahsilat Yazdır ")])),_:1})])),_:1})])])])),_:1})])),_:1})])),_:1},8,["modelValue"]),(0,i.Wm)(Re,{modelValue:ie.updateInvoiceNumberDialog,"onUpdate:modelValue":t[19]||(t[19]=e=>ie.updateInvoiceNumberDialog=e),persistent:""},{default:(0,i.w5)((()=>[(0,i.Wm)(We,{style:{width:"450px"}},{default:(0,i.w5)((()=>[(0,i.Wm)(_e,{style:{height:"50px"}},{default:(0,i.w5)((()=>[Q,(0,i.Wm)(fe),(0,i.wy)(((0,i.wg)(),(0,i.j4)(se,{dense:"",flat:"",icon:"close"},{default:(0,i.w5)((()=>[(0,i.Wm)(be,null,{default:(0,i.w5)((()=>[(0,i.Uk)("Kapat")])),_:1})])),_:1})),[[ke]])])),_:1}),(0,i.Wm)(xe,null,{default:(0,i.w5)((()=>[A,(0,i._)("div",L,[(0,i.Wm)(ye,{onSubmit:oe.onUpdateInvoice,class:"col-12"},{default:(0,i.w5)((()=>[(0,i._)("div",B,[(0,i.Wm)(ne,{"lazy-rules":!0,rules:[e=>e&&e.toString().length>0||"Zorunlu alan"],dense:"",outlined:"",modelValue:ie.invoiceNumberEditFields.InvoiceNo,"onUpdate:modelValue":t[18]||(t[18]=e=>ie.invoiceNumberEditFields.InvoiceNo=e)},null,8,["rules","modelValue"])]),(0,i._)("div",O,[(0,i.Wm)(se,{type:"submit",color:"blue-grey-8",icon:"update",label:"Güncelle"})])])),_:1},8,["onSubmit"])])])),_:1})])),_:1})])),_:1},8,["modelValue"]),(0,i.Wm)(Re,{modelValue:ie.updateReceiptNumberDialog,"onUpdate:modelValue":t[21]||(t[21]=e=>ie.updateReceiptNumberDialog=e),persistent:""},{default:(0,i.w5)((()=>[(0,i.Wm)(We,{style:{width:"450px"}},{default:(0,i.w5)((()=>[(0,i.Wm)(_e,{style:{height:"50px"}},{default:(0,i.w5)((()=>[H,(0,i.Wm)(fe),(0,i.wy)(((0,i.wg)(),(0,i.j4)(se,{dense:"",flat:"",icon:"close"},{default:(0,i.w5)((()=>[(0,i.Wm)(be,null,{default:(0,i.w5)((()=>[(0,i.Uk)("Kapat")])),_:1})])),_:1})),[[ke]])])),_:1}),(0,i.Wm)(xe,null,{default:(0,i.w5)((()=>[Y,(0,i._)("div",j,[(0,i.Wm)(ye,{onSubmit:oe.onUpdateReceipt,class:"col-12"},{default:(0,i.w5)((()=>[(0,i._)("div",K,[(0,i.Wm)(ne,{"lazy-rules":!0,rules:[e=>e&&e.toString().length>0||"Zorunlu alan"],dense:"",outlined:"",modelValue:ie.receiptNumberEditFields.ReceiptCollectionNo,"onUpdate:modelValue":t[20]||(t[20]=e=>ie.receiptNumberEditFields.ReceiptCollectionNo=e)},null,8,["rules","modelValue"])]),(0,i._)("div",G,[(0,i.Wm)(se,{type:"submit",color:"blue-grey-8",icon:"update",label:"Güncelle"})])])),_:1},8,["onSubmit"])])])),_:1})])),_:1})])),_:1},8,["modelValue"]),(0,i.Wm)(Re,{modelValue:ie.updateReservationNumberDialog,"onUpdate:modelValue":t[23]||(t[23]=e=>ie.updateReservationNumberDialog=e),persistent:""},{default:(0,i.w5)((()=>[(0,i.Wm)(We,{style:{width:"450px"}},{default:(0,i.w5)((()=>[(0,i.Wm)(_e,{style:{height:"50px"}},{default:(0,i.w5)((()=>[J,(0,i.Wm)(fe),(0,i.wy)(((0,i.wg)(),(0,i.j4)(se,{dense:"",flat:"",icon:"close"},{default:(0,i.w5)((()=>[(0,i.Wm)(be,null,{default:(0,i.w5)((()=>[(0,i.Uk)("Kapat")])),_:1})])),_:1})),[[ke]])])),_:1}),(0,i.Wm)(xe,null,{default:(0,i.w5)((()=>[X,(0,i._)("div",ee,[(0,i.Wm)(ye,{onSubmit:oe.onUpdateReservationNumber,class:"col-12"},{default:(0,i.w5)((()=>[(0,i._)("div",te,[(0,i.Wm)(ne,{"lazy-rules":!0,rules:[e=>e&&e.toString().length>0||"Zorunlu alan"],dense:"",outlined:"",modelValue:ie.reservationNumberEditFields.ReservationNo,"onUpdate:modelValue":t[22]||(t[22]=e=>ie.reservationNumberEditFields.ReservationNo=e)},null,8,["rules","modelValue"])]),(0,i._)("div",ae,[(0,i.Wm)(se,{type:"submit",color:"blue-grey-8",icon:"update",label:"Güncelle"})])])),_:1},8,["onSubmit"])])])),_:1})])),_:1})])),_:1},8,["modelValue"])])}a(71);var le=a(261),oe=a(5081),se=a(6427),re=a(6597),ne=a(1959);const de=[{name:"id",label:"ID",align:"center",sortable:!0,field:"id"},{name:"Status",label:"Statüs",align:"center",field:"Status",sortable:!0},{name:"Pickup",label:"Aracı Alma Konumu",align:"center",field:"Pickup",sortable:!0},{name:"Return",label:"Aracı Bırakma Konumu",align:"center",field:"Return",sortable:!0},{name:"Car",label:"Araç",field:"Car",align:"center"},{name:"Customer",label:"Müşteri",field:"Customer",align:"center"},{name:"Amount",label:"Ödeme",field:"Amount",align:"left"},{name:"id",label:"",field:"id"}],ue=[{id:1,Info:"Detay",Pickup:"Alma Detayı",Return:"Bırakma Detayı",Car:"Araç Bilgileri",Customer:"Müşteri Bilgileri",Amount:"Ödeme Bilgileri"}],ce={name:"ReservationsIndex",setup(){return{reservationManageDialog:(0,ne.iH)(!1),invoiceManageDialog:(0,ne.iH)(!1),updateInvoiceNumberDialog:(0,ne.iH)(!1),updateReceiptNumberDialog:(0,ne.iH)(!1),updateReservationNumberDialog:(0,ne.iH)(!1),columns:de,rows:ue,filter:(0,ne.iH)(""),reservationFields:(0,ne.iH)({ReservationStatus:"",PaymentState:"",id:null}),invoiceManageFields:(0,ne.iH)({reservationId:""}),invoiceNumberEditFields:(0,ne.iH)({id:"",InvoiceNo:""}),receiptNumberEditFields:(0,ne.iH)({id:"",ReceiptCollectionNo:""}),reservationNumberEditFields:(0,ne.iH)({id:"",ReservationNo:""})}},components:{ShowLocation:le.Z,Vehicle:oe.Z,Customer:se.Z,Payment:re.Z},computed:{currentReservations(){return this.$store.getters["Reservations/oldReservationsGetter"]},reservationStatus(){return this.$store.getters["MainModule/getReservationStatus"]},reservationPaymentStates(){return this.$store.getters["MainModule/getReservationTransactionStates"]}},mounted(){this.$store.dispatch("Reservations/getOldReservations")},methods:{reservationUpdateHandleBtn(e,t,a){this.reservationFields.id=e,this.reservationManageDialog=!0,this.reservationFields.ReservationStatus=this.reservationStatus.find((e=>e.code===t)).code,this.reservationFields.PaymentState=this.reservationPaymentStates.find((e=>e.code===a)).code},onsubmitReservationStatus(){let e=new FormData;e.append("ReservationStatus",this.reservationFields.ReservationStatus),e.append("PaymentState",this.reservationFields.PaymentState),e.append("id",this.reservationFields.id),e.append("_method","PUT"),this.$store.dispatch("Reservations/updateReservationStatus",e).then((e=>{!0===e&&(this.reservationManageDialog=!1)}))},reservationsStatus(e){return this.reservationStatus.find((t=>t.code===e)).title},reservationStatusColor(e){switch(e){case"WaitingForApproval":return{color:"secondary",icon:"query_builder"};case"Continues":return{color:"blue-9",icon:"av_timer"};case"Cancelled":return{color:"negative",icon:"highlight_off"};case"Completed":return{color:"blue-grey-8",icon:"verified_user"}}},invoiceManage(e){this.invoiceManageDialog=!0,this.invoiceManageFields=this.currentReservations.find((t=>+t.id===+e))},editInvoiceNumber(e,t){this.updateInvoiceNumberDialog=!0,this.invoiceNumberEditFields.id=e,this.invoiceNumberEditFields.InvoiceNo=t},editReceiptNumber(e,t){this.updateReceiptNumberDialog=!0,this.receiptNumberEditFields.id=e,this.receiptNumberEditFields.ReceiptCollectionNo=t},editReservationNumber(e,t){this.updateReservationNumberDialog=!0,this.reservationNumberEditFields.id=e,this.reservationNumberEditFields.ReservationNo=t},onUpdateInvoice(){let e=new FormData;for(const[t,a]of Object.entries(this.invoiceNumberEditFields))e.append(t,a);e.append("_method","PUT"),this.$store.dispatch("Reservations/invoiceNumberUpdate",e).then((e=>{!0===e&&(this.updateInvoiceNumberDialog=!1)}))},onUpdateReceipt(){let e=new FormData;for(const[t,a]of Object.entries(this.receiptNumberEditFields))e.append(t,a);e.append("_method","PUT"),this.$store.dispatch("Reservations/receiptNumberUpdate",e).then((e=>{!0===e&&(this.updateReceiptNumberDialog=!1)}))},onUpdateReservationNumber(){let e=new FormData;for(const[t,a]of Object.entries(this.reservationNumberEditFields))e.append(t,a);this.$store.dispatch("Reservations/reservationNumberUpdate",e).then((e=>{!0===e&&(this.updateReservationNumberDialog=!1)}))},currentReservationFilter(e){const t=JSON.parse(JSON.stringify(this.filter)).toLowerCase();return e.filter((e=>e.CustomerNameSurname.toLowerCase().indexOf(t)>-1||e.DropLocation.toLowerCase().indexOf(t)>-1||e.PickupLocation.toLowerCase().indexOf(t)>-1||e.ModelName.toLowerCase().indexOf(t)>-1||e.BrandName.toLowerCase().indexOf(t)>-1||e.LicencePlate.toLowerCase().indexOf(t)>-1))}}};var me=a(4260),pe=a(4993),ve=a(2165),be=a(4689),ge=a(4554),we=a(8186),fe=a(3884),_e=a(7030),he=a(8870),ye=a(4390),xe=a(151),We=a(846),Re=a(2025),Ne=a(5589),ke=a(5269),Fe=a(3314),Se=a(5869),Me=a(677),Ce=a(7518),De=a.n(Ce);const Ue=(0,me.Z)(ce,[["render",ie]]),ze=Ue;De()(ce,"components",{QTable:pe.Z,QBtn:ve.Z,QInput:be.Z,QIcon:ge.Z,QTr:we.Z,QTd:fe.Z,QChip:_e.Z,QTooltip:he.Z,QDialog:ye.Z,QCard:xe.Z,QBar:We.Z,QSpace:Re.Z,QCardSection:Ne.Z,QForm:ke.Z,QSelect:Fe.Z,QSeparator:Se.Z}),De()(ce,"directives",{ClosePopup:Me.Z})}}]);
function createalert(e,t,n=null){if(null!=n)var a=document.querySelector(`form#${n} #messages`);else a=document.querySelector("#messages");a.style.display="none",a.innerHTML="";var i=document.createElement("div");i.className="alert "+e,i.textContent=t,a.appendChild(i),a.style.display="block",setTimeout(function(){fadeOut(i)},2e3),window.scrollTo({top:0,behavior:"smooth"})}function fadeOut(e){var t=1,n=setInterval(function(){t<=.1&&(clearInterval(n),e.style.display="none",document.querySelector("#messages").style.display="none"),e.style.opacity=t,t-=.1},50)}function togglepopup(e){var t=document.querySelector("#"+e);t.classList.contains("active")?t.classList.remove("active"):t.classList.add("active")}function isValidEmail(e){return/\S+@\S+\.\S+/.test(e)}function validPhone(e){var t=e.replace(/\D/g,"").match(/(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);return t[2]?t[1]+" "+t[2]+(t[3]?" "+t[3]:"")+(t[4]?" "+t[4]:""):t[1]}function password_toggle(e){let t=document.querySelector('input[name="'+e+'"]'),n=document.querySelector("span#"+e+"-eye-icon");"password"===t.type?(t.type="text",n.classList.add("active"),n.innerHTML='<i class="las la-eye-slash"></i>'):(t.type="password",n.classList.remove("active"),n.innerHTML='<i class="las la-eye"></i>')}function sendAjaxRequest(e,t="post",n=null,a){var i=new XMLHttpRequest;i.onreadystatechange=function(){4===i.readyState&&(200===i.status?a(null,i.responseText):a(i.statusText))},"post"==t?(i.open("POST",e),i.setRequestHeader("Content-Type","application/json"),i.send(JSON.stringify(n))):(i.open("GET",e),i.send())}function phonewriting(e){var t=validPhone(document.querySelector('input[name="'+e+'"]').value);document.querySelector('input[name="'+e+'"]').value=t}function bookmarktoggle(e,t,n){sendAjaxRequest(`${n}`,"post",{code:e,language:t},function(t,n){if(t)createalert("error",t);else{var a=document.querySelector("#service-"+e).querySelector(".bookmark");a&&(a.classList.contains("active")?(a.classList.remove("active"),a.innerHTML="<i class='las la-bookmark'></i>"):(a.classList.add("active"),a.innerHTML="<i class='fa fa-bookmark'></i>"))}})}function toggledropdowforcreator(e){var t=document.getElementById("service-"+e).querySelector(".dropdown");t.classList.contains("active")?t.classList.remove("active"):t.classList.add("active")}function deletequeryservice(e,t,n,a){var i=document.getElementById("modal-wrapper");i&&i.remove();var l={az_delete:"Xeyir",ru_delete:"Неа",en_delete:"No",az_confirm:"Bəli",ru_confirm:"Да",en_confirm:"Yes"},s=`<div id="modal-wrapper">
    <div id="custom-modal">
        <p> ${n} </p>
        <div class="modal-buttons">
            <button onclick="cancelmodal()" class="error"> ${l[a+"_delete"]}
            </button> <button onclick="submitdeletemodal('${e}','${t}','${a}')" class="success">
                ${l[a+"_confirm"]} </button>
        </div>
    </div>
</div>
`;document.body.innerHTML+=s}function cancelmodal(){var e=document.getElementById("modal-wrapper");e&&e.remove()}function submitdeletemodal(e,t,n){sendAjaxRequest("/api/deleteservice","post",{code:e,auth:t,lang:n},function(e,t){if(e)createalert("error",e);else{let n=JSON.parse(t);createalert(n.status,n.message)}}),cancelmodal(),document.getElementById(`service-${e}`).remove()}function createpaymentlink(e=null,t=null,n="az",a=!0){null!=e?sendAjaxRequest(`/api/serviceinfo/${e}`,"get",null,function(e,i){e?createalert("error",e):openservicemodal(JSON.parse(i),t,n,a)}):openservicesmodal()}function openservicemodal(e,t=null,n="az",a){var i=document.getElementById("modal-wrapper");i&&i.remove();var l={az_allservices:"B\xfct\xfcn xidmətlər",ru_allservices:"Все услуги",en_allservices:"All services",az_service_title:"Xidmət haqqında \xfcmumi məlumat",ru_service_title:"Общая информация об услуге",en_service_title:"General information about the service",az_price:"Qiymət",en_price:"Price",ru_price:"Цена",az_createlink:"\xd6dəniş linkini yarat",ru_createlink:"Создать платежную ссылку",en_createlink:"Create payment link"},s=`<div id="modal-wrapper">
        <div class="modal_section">
            <div class="w-100 right">
                <span class="cancel_icon" onclick="cancelmodal()">
                    <i class="las la-times">
                    </i></span>
            </div>
            <div class="modal_content">
                <div class="w-100 center">
                    <h2 class="service_title"> ${l[n+"_service_title"]} </h2>
                </div>
                <div class="w-100 left">
                    <h4 class="service_name"> ${e.name[n+"_name"]} </h4>
                </div>
                <div class="w-100 left">
                                    </div>
                <div class="w-100 justify">
                    <div class="clumn column-40">
                        <div class="form-group">
                            <label> ${l[n+"_price"]} </label>
                            <div class="form-control"> <input placeholder="${l[n+"_price"]} €" id="price_input" name="price"
                                    value="${e.price}" />
                                <span class="inputsymbol">
                                    € </span>
                            </div>
                        </div>
                    </div>
                    <div class="column column-60">
                        <button class="create_link"
                            onclick="createandwritelink('${e.user_id}','${t}','${e.code}','${n}','created_link')">
                            <i class="las la-link">
                            </i>
                            ${l[n+"_createlink"]}</button>
                    </div>
                </div>
                <div class="w-100 center d-none" id="created_link">
                    <div class="created_link">
                    </div>
                    <span class="copy_button" onclick="copyelement('created_link','copy_button')"><i
                            class="las la-clipboard"></i>
                    </span>
                </div>
            </div>

        </div>
    `;document.body.innerHTML+=s}function copyelement(e,t){var n=document.querySelector("div."+e).textContent;navigator.clipboard.writeText(n);var a=document.querySelector("span."+t);a.innerHTML='<i class="las la-check-circle"></i>',a.classList.add("active"),setTimeout(function(){a.innerHTML='<i class="las la-clipboard"></i>',a.classList.remove("active")},1500)}function createandwritelink(e,t=null,n,a="az",i){sendAjaxRequest(`/api/createupayment?sender_id=${e}&receiver_id=${null!=t?t:null}&service_id=${n}&price=${document.getElementById("price_input").value}&language=${a}`,"get",null,function(e,t){if(e)createalert("error",e);else if(null!=t&&t.length>0){document.querySelector("#"+i).classList.remove("d-none");var n=document.querySelector("."+i);n.innerHTML="",n.innerHTML=t}})}function searchinfields(e,t,n="services",a=null){if(null!=a){if("category"==a){var i={category:e,type:n,action:a};document.querySelectorAll(".category-item").forEach(function(e){e.classList.remove("active")});for(var l=document.querySelectorAll(".category-item."+e),s=0;s<l.length;s++)l[s].classList.contains("active")?l[s].classList.remove("active"):l[s].classList.add("active")}}else i={query:document.getElementsByName(e)[0].value,type:n,action:a};var r=document.getElementById(t);sendAjaxRequest("/api/searchinfilled","post",i,function(e,t){if(e)createalert("error",e);else{let n=JSON.parse(t);r.innerHTML="",r.innerHTML=n.view}})}function change_filter(e,t="datas",n="az",a="services"){for(var i=document.querySelectorAll(".filter_view"),l=0;l<i.length;l++)i[l].classList.remove("active");var s=document.querySelector("."+e);s.classList.contains("active")?s.classList.remove("active"):s.classList.add("active");let r=[];"services"==a&&document.querySelectorAll(".service_one").forEach(e=>{let t=e.getAttribute("id").replace("service-","");r.push(t)});var c=document.getElementById(t);sendAjaxRequest("/api/filterelements","post",{ids:r,type:a,orderby:e,language:n},function(e,t){if(e)createalert("error",e);else{let n=JSON.parse(t);c.innerHTML="",c.innerHTML=n.view}})}function changetab(e){for(var t=document.querySelectorAll(".tab"),n=0;n<t.length;n++)t[n].classList.remove("active");document.querySelector("."+e).classList.add("active");var a=document.querySelectorAll(".tab_element");for(n=0;n<a.length;n++)a[n].classList.remove("active");document.querySelector("#"+e).classList.add("active")}function showLoader(){document.getElementById("loader").classList.add("active")}function hideLoader(){document.getElementById("loader").classList.remove("active")}
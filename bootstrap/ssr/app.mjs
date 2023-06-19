import _ from "lodash";
import dayjs$1 from "dayjs";
import "dayjs/locale/en.js";
import "dayjs/locale/az.js";
import "dayjs/locale/ru.js";
import relativeTime from "dayjs/plugin/relativeTime.js";
import axios$1 from "axios";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import { useSSRContext, mergeProps, resolveComponent, createApp } from "vue";
import { ssrRenderList, ssrRenderAttr, ssrInterpolate, ssrRenderAttrs, ssrRenderClass, ssrRenderStyle, ssrRenderComponent } from "vue/server-renderer";
window._ = _;
dayjs$1.extend(relativeTime);
window.axios = axios$1;
window.dayjs = dayjs$1;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: "pusher",
    key: "${PUSHER_APP_KEY}",
    cluster: "${PUSHER_APP_CLUSTER}",
    forceTLS: true
});
const _export_sfc = (sfc, props) => {
    const target = sfc.__vccOpts || sfc;
    for (const [key, val] of props) {
        target[key] = val;
    }
    return target;
};
const _sfc_main$4 = {
    props: ["users", "currentroom", "locale", "authenticated"],
    data: function() {
        return {
            selected: ""
        };
    },
    methods: {
        getsubstr(value, length = 10) {
            if (!value)
                return "";
            if (value.length <= length)
                return value;
            return value.substring(0, length) + "...";
        },
        formatDate: function(value) {
            dayjs.locale(this.locale);
            if (value) {
                return dayjs(value).fromNow();
            }
        },
        countmessages(messages) {
            var notreadedmessages = 0;
            for (var i = 0; i < messages.length; i++) {
                notreadedmessages += messages[i].status === false ? 1 : 0;
            }
            return notreadedmessages;
        }
    },
    created() {
        this.selected = this.currentroom;
    }
};

function _sfc_ssrRender$4(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
    _push(`<!--[-->`);
    ssrRenderList($props.users, (userone) => {
        _push(`<div class="message_left_element">`);
        if ($props.authenticated && $props.authenticated.type == 3) {
            _push(`<div class="image"><img${ssrRenderAttr("src", userone.receiverinfo.additionalinfo != null && userone.receiverinfo.additionalinfo.company_image != null ? "/temp/" + userone.receiverinfo.additionalinfo.company_image : "/assets/images/no-user.png")}${ssrRenderAttr("alt", userone.receiverinfo.name_surname)}></div>`);
        } else {
            _push(`<div class="image"><img${ssrRenderAttr("src", userone.senderinfo.additionalinfo != null && userone.senderinfo.additionalinfo.company_image != null ? "/temp/" + userone.senderinfo.additionalinfo.company_image : "/assets/images/no-user.png")}${ssrRenderAttr("alt", userone.senderinfo.name_surname)}></div>`);
        }
        _push(`<div class="content"><div class="info">`);
        if ($props.authenticated && $props.authenticated.type == 3) {
            _push(`<h5 class="name">${ssrInterpolate(userone.receiverinfo.type == 1 ? userone.receiverinfo.name_surname : userone.receiverinfo.additionalinfo.company_name.az_name)}</h5>`);
        } else {
            _push(`<h5 class="name">${ssrInterpolate(userone.senderinfo.type == 1 ? userone.senderinfo.name_surname : userone.senderinfo.additionalinfo.company_name.az_name)}</h5>`);
        }
        if (userone.message_elements && userone.message_elements.length > 0) {
            _push(`<p class="description">${ssrInterpolate($options.getsubstr(userone.message_elements[0].message, 40))}</p>`);
        } else {
            _push(`<!---->`);
        }
        _push(`</div></div>`);
        if (userone.message_elements.length > 0) {
            _push(`<div class="right-section"><div class="date">${ssrInterpolate($options.formatDate(userone.message_elements[0].created_at))}</div><div class="status">`);
            if (userone.message_elements[0].status == 0) {
                _push(`<span class="badge">${ssrInterpolate($options.countmessages(userone.message_elements))}</span>`);
            } else {
                _push(`<span><i class="las la-check-double"></i></span>`);
            }
            _push(`</div></div>`);
        } else {
            _push(`<!---->`);
        }
        _push(`</div>`);
    });
    _push(`<!--]-->`);
}
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
    const ssrContext = useSSRContext();
    (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/MessageList.vue");
    return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const MessageList = /* @__PURE__ */ _export_sfc(_sfc_main$4, [
    ["ssrRender", _sfc_ssrRender$4]
]);
const _sfc_main$3 = {
    props: [
        "currentroom",
        "messages",
        "locale",
        "authenticated"
    ],
    methods: {
        formatDate: function(value) {
            dayjs.locale(this.locale);
            if (value) {
                return dayjs(value).fromNow();
            }
        },
        readedMessage(message) {
            if (message.status == false) {
                axios.post("/readmessage/" + message.id).then((response) => {}).catch((error) => {
                    console.log(error);
                });
            }
        },
        redirectToCompany(slugs) {
            var url;
            if (this.locale == "az") {
                url = `/company/${slugs.az_slug}`;
            } else if (this.locale == "ru") {
                url = `/company/${slugs.ru_slug}`;
            } else if (this.locale == "en") {
                url = `/company/${slugs.en_slug}`;
            }
            window.open(url, "_blank");
        },
        isURL(str) {
            const urlPattern = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/;
            return urlPattern.test(str);
        }
    },
    mounted() {
        this.messages.forEach((message) => {
            this.readedMessage(message);
        });
    },
    updated() {
        this.messages.forEach((message) => {
            this.readedMessage(message);
        });
    }
};

function _sfc_ssrRender$3(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
    _push(`<div${ssrRenderAttrs(mergeProps({ class: "message_containers" }, _attrs))}>`);
    if ($props.authenticated && $props.authenticated.type == 1) {
        _push(`<div class="receiver_area"><div class="photo"><img${ssrRenderAttr("src", $props.currentroom.senderinfo.additionalinfo != null && $props.currentroom.senderinfo.additionalinfo.company_image != null ? "/temp/" + $props.currentroom.senderinfo.additionalinfo.company_image : "/assets/images/no-user.png")} alt="currentroom.senderinfo.name_surname"></div><div class="info"><h5>${ssrInterpolate($props.currentroom.senderinfo.type == 1 ? $props.currentroom.senderinfo.name_surname : $props.currentroom.senderinfo.additionalinfo.company_name.az_name)}</h5></div></div>`);
    } else {
        _push(`<div class="receiver_area"><div class="photo"><img${ssrRenderAttr("src", $props.currentroom.receiverinfo.additionalinfo != null && $props.currentroom.receiverinfo.additionalinfo.company_image != null ? "/temp/" + $props.currentroom.receiverinfo.additionalinfo.company_image : "/assets/images/no-user.png")} alt="currentroom.receiverinfo.name_surname"></div><div class="info"><h5>${ssrInterpolate($props.currentroom.receiverinfo.type == 1 ? $props.currentroom.receiverinfo.name_surname : $props.currentroom.receiverinfo.additionalinfo.company_name.az_name)}</h5></div></div>`);
    }
    _push(`<div class="message_elements_area"><!--[-->`);
    ssrRenderList($props.messages, (message, index) => {
        _push(`<div class="${ssrRenderClass({ "message-element": true, "sender": message.user_id == $props.authenticated.id })}"><div class="message-content">`);
        if ($options.isURL(message.message)) {
            _push(`<a${ssrRenderAttr("href", message.message)} target="_blank">${ssrInterpolate(message.message)}</a>`);
        } else {
            _push(`<!--[-->${ssrInterpolate(message.message)}<!--]-->`);
        }
        _push(`</div><div class="time">${ssrInterpolate($options.formatDate(message.created_at))}</div></div>`);
    });
    _push(`<!--]--></div></div>`);
}
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
    const ssrContext = useSSRContext();
    (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/MessagesContainer.vue");
    return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const MessagesContainer = /* @__PURE__ */ _export_sfc(_sfc_main$3, [
    ["ssrRender", _sfc_ssrRender$3]
]);
const _sfc_main$2 = {
    props: ["currentroom", "authenticated"],
    data() {
        return {
            message: ""
        };
    },
    methods: {
        sendmessage() {
            if (this.message == " ") {
                return;
            }
            axios.post("/sendmessage/" + this.currentroom.id, { message: this.message }).then((response) => {
                if (response.status == 201) {
                    this.message = "";
                    this.$emit("sendmessage");
                }
            }).catch((error) => console.log(error));
        },
        showmodalsendlink() {
            console.log("clicked");
        }
    }
};

function _sfc_ssrRender$2(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
    _push(`<div${ssrRenderAttrs(mergeProps({ class: "message_input_area" }, _attrs))}><div class="form-group">`);
    if ($props.authenticated.type == 3 ? true : false) {
        _push(`<span class="link"><i class="las la-link"></i></span>`);
    } else {
        _push(`<!---->`);
    }
    _push(`<input class="form-control"${ssrRenderAttr("value", $data.message)} placeholder="İsmarıcınızı yazın"></div><button class="send_message"><i class="las la-paper-plane"></i></button></div>`);
}
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
    const ssrContext = useSSRContext();
    (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/MessageInput.vue");
    return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const MessageInput = /* @__PURE__ */ _export_sfc(_sfc_main$2, [
    ["ssrRender", _sfc_ssrRender$2]
]);
const _sfc_main$1 = {
    props: ["currentroom", "authenticated", "locale", "userservices"],
    data() {
        return {
            selectedservice: [],
            translations: {
                az: {
                    search: "Axtar",
                    choise: "Seç",
                    null: "Məlumat yoxdur",
                    allservices: "Bütün xidmətlər",
                    service_title: "Xidmət haqqında ümumi məlumat",
                    price: "Qiymət",
                    createlink: "Ödəniş linkini yarat"
                },
                ru: {
                    search: "Поиск",
                    choise: "выбирать",
                    null: "Нет информации",
                    allservices: "Все услуги",
                    service_title: "Общая информация об услуге",
                    price: "Цена",
                    createlink: "Создать платежную ссылку"
                },
                en: {
                    search: "Search",
                    choise: "Choise",
                    null: "There is no information",
                    allservices: "All services",
                    service_title: "General information about the service",
                    price: "Price",
                    createlink: "Create payment link"
                }
            },
            searching: "",
            price: "",
            userservices_val: [],
            createdLink: ""
        };
    },
    methods: {
        translated(type, data = null) {
            if (this.locale === "az") {
                if (data != null) {
                    if (type == "name") {
                        return data.az_name;
                    } else if (type == "description") {
                        return data.az_description;
                    }
                } else {
                    return this.translations.az[type];
                }
            } else if (this.locale === "ru") {
                if (data != null) {
                    if (type == "name") {
                        return data.ru_name;
                    } else if (type == "description") {
                        return data.ru_description;
                    }
                } else {
                    return this.translations.ru[type];
                }
            } else if (this.locale === "en") {
                if (data != null) {
                    if (type == "name") {
                        return data.en_name;
                    } else if (type == "description") {
                        return data.en_description;
                    }
                } else {
                    return this.translations.en[type];
                }
            }
        },
        searchnow() {
            this.userservices_val = [];
            axios.get("/api/services_user/" + this.currentroom.sender_id + "/" + this.searching).then((response) => {
                this.userservices_val = response.data;
            }).catch((error) => {
                console.error(error);
            });
        },
        getsubstr(value, length = 10) {
            if (!value)
                return "";
            if (value.length <= length)
                return value;
            return value.substring(0, length) + "...";
        },
        selectservice(service) {
            this.selectedservice = service;
        },
        resetserviceselected() {
            this.selectedservice = [];
            this.createdLink = "";
        },
        createandwritelink(sender_id, receiver_id, service_id, language = "az", classofarea) {
            this.createdLink = "";
            axios.get("/api/createupayment?sender_id=" + sender_id + "&receiver_id=" + receiver_id + "&service_id=" + service_id + "&price" + this.price + "&language=" + language).then((response) => {
                this.createdLink = response.data;
            }).catch((error) => {
                console.error(error);
            });
        },
        copyelement(copyelement, copybutton) {
            var element = document.querySelector("div." + copyelement).textContent;
            navigator.clipboard.writeText(element);
            var button = document.querySelector("span." + copybutton);
            button.innerHTML = '<i class="las la-check-circle"></i>';
            button.classList.add("active");
            setTimeout(function() {
                button.innerHTML = '<i class="las la-clipboard"></i>';
                button.classList.remove("active");
            }, 1500);
        }
    },
    mounted() {
        this.userservices_val = this.userservices;
    },
    created() {
        this.userservices_val = this.userservices;
    }
};

function _sfc_ssrRender$1(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
    _push(`<div${ssrRenderAttrs(mergeProps({ id: "modal-wrapper" }, _attrs))}><div class="modal_section"><div class="w-100 right"><span class="cancel_icon"><i class="las la-times"></i></span></div>`);
    if ($data.selectedservice.id) {
        _push(`<div><div class="w-100"><span class="cancel-icon"><i class="las la-arrow-left"></i></span>   ${ssrInterpolate($options.translated("allservices"))}</div><div class="modal_content"><div class="w-100 center"><h2 class="service_title">${ssrInterpolate($options.translated("service_title"))}</h2></div><div class="w-100 left"><h4 class="service_name">${ssrInterpolate($options.translated("name", $data.selectedservice.name))}</h4></div><div class="w-100 left"><p class="service_description">${ssrInterpolate($options.translated("description", $data.selectedservice.description))}</p></div><div class="w-100 justify"><div class="clumn column-40"><div class="form-group"><label></label><div class="form-control"><input placeholder=" €" name="price"${ssrRenderAttr("value", $data.selectedservice.price)}><span class="inputsymbol">€</span></div></div></div><div class="column column-60"><button class="create_link"><i class="las la-link"></i>${ssrInterpolate($options.translated("createlink"))}</button></div></div><div class="${ssrRenderClass([{ "d-none": $data.createdLink == "" }, "w-100 center"])}" id="created_link"><div class="created_link">${$data.createdLink}</div> <span class="copy_button"><i class="las la-clipboard"></i></span></div></div></div>`);
    } else {
        _push(`<div><form style="${ssrRenderStyle({ "height": "50px" })}" class="row"><div class="form-group"><input type="text"${ssrRenderAttr("value", $data.searching)} class="form-control" name="search"${ssrRenderAttr("placeholder", $options.translated("search"))} style="${ssrRenderStyle({ "width": "85%" })}"></div></form>`);
        if ($data.userservices_val.length > 0) {
            _push(`<div class="message_elements_area"><!--[-->`);
            ssrRenderList($data.userservices_val, (service, index) => {
                _push(`<div class="service_element_on_modal"><div class="image"><img${ssrRenderAttr("src", service.images[0] != null ? "/temp/" + service.images[0].original_images : "/assets/images/no-user.png")}${ssrRenderAttr("alt", service.name.az_name)}></div><div class="info"><h3>${ssrInterpolate($options.translated("name", service.name))} <p>${ssrInterpolate($options.getsubstr($options.translated("description", service.description), 40))}</p></h3></div><div class="right"><button class="buttonselect">${ssrInterpolate($options.translated("choise"))}</button></div></div>`);
            });
            _push(`<!--]--></div>`);
        } else {
            _push(`<div class="row text-center"><p class="text-center text-danger">${ssrInterpolate($options.translated("null"))}</p></div>`);
        }
        _push(`</div>`);
    }
    _push(`</div></div>`);
}
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
    const ssrContext = useSSRContext();
    (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/ModalServices.vue");
    return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const ModalServices = /* @__PURE__ */ _export_sfc(_sfc_main$1, [
    ["ssrRender", _sfc_ssrRender$1]
]);
const _sfc_main = {
    components: {
        MessageList,
        MessagesContainer,
        MessageInput,
        ModalServices
    },
    data() {
        return {
            users: [],
            currentroom: [],
            messages: [],
            locale: "az",
            authenticated: [],
            showmodal: false,
            userservices: []
        };
    },
    watch: {
        currentroom(val, oldval) {
            if (oldval != null && oldval.id) {
                this.disconnect(oldval);
            }
            this.connect();
        }
    },
    methods: {
        connect() {
            if (this.currentroom != null && this.currentroom.id) {
                let vm = this;
                window.Echo.private("chat." + this.currentroom.id).listen(".App\\Events\\NewChatMessage", (e) => {
                    vm.getAllData();
                });
            }
        },
        disconnect(room) {
            if (room != null && room.id) {
                window.Echo.leave("chat." + room.id);
            }
        },
        getUsers() {
            axios.get("/fetchmessagegroups").then((response) => {
                this.users = response.data.data;
            }).catch((error) => console.error(error));
        },
        setRoom(userone) {
            this.currentroom = Object.assign({}, userone);
            this.getMessagesFromRoom();
            this.connect(this.currentroom);
        },
        getMessagesFromRoom() {
            axios.get("/fetchmessages/" + this.currentroom.id).then((response) => {
                this.messages = response.data.data;
            }).catch((error) => console.error(error));
        },
        getLocale() {
            axios.get("/locale").then((response) => {
                this.locale = response.data.locale;
            }).catch((error) => {
                console.error(error);
            });
        },
        getAllData(event) {
            this.getMessagesFromRoom();
            this.getUsers();
        },
        getauthenticated() {
            axios.get("/authenticated").then((response) => {
                this.authenticated = response.data;
            }).catch((error) => {
                console.error(error);
            });
        },
        openservicemodal() {
            this.showmodal = !this.showmodal;
            this.userservices = [];
            if (this.showmodal == true) {
                axios.get("/api/services_user/" + this.currentroom.sender_id).then((response) => {
                    this.userservices = response.data;
                }).catch((error) => {
                    console.error(error);
                });
            }
        }
    },
    created() {
        this.getauthenticated();
        this.getLocale();
        this.getUsers();
        this.connect();
    }
};

function _sfc_ssrRender(_ctx, _push, _parent, _attrs, $props, $setup, $data, $options) {
    const _component_message_list = resolveComponent("message-list");
    const _component_messages_container = resolveComponent("messages-container");
    const _component_message_input = resolveComponent("message-input");
    const _component_modal_services = resolveComponent("modal-services");
    _push(`<!--[--><section><div class="container">`);
    if ($data.users.length > 0) {
        _push(`<div class="w-100 row message_lists"><div class="message_left_column">`);
        _push(ssrRenderComponent(_component_message_list, {
            authenticated: $data.authenticated[0],
            users: $data.users,
            locale: $data.locale,
            currentroom: $data.currentroom,
            onRoomchanged: ($event) => $options.setRoom($event)
        }, null, _parent));
        _push(`</div>`);
        if ($data.currentroom.id) {
            _push(`<div class="message_right_column">`);
            _push(ssrRenderComponent(_component_messages_container, {
                authenticated: $data.authenticated[0],
                messages: $data.messages,
                locale: $data.locale,
                onReadedMessage: ($event) => $options.getAllData($event),
                currentroom: $data.currentroom
            }, null, _parent));
            _push(ssrRenderComponent(_component_message_input, {
                currentroom: $data.currentroom,
                authenticated: $data.authenticated[0],
                locale: $data.locale,
                onShowmodalsendlink: $options.openservicemodal,
                onSendmessage: $options.getAllData
            }, null, _parent));
            _push(`</div>`);
        } else {
            _push(`<div class="row w-100 message_right_column message_center_show_alert"><p class="text-center text-danger">Sol tərəfdən istifadəçini seçin.</p></div>`);
        }
        _push(`</div>`);
    } else {
        _push(`<div class="row w-100 message_center_show_alert"><p class="text-center text-danger">Heç bir yazışmanız yoxdur.</p></div>`);
    }
    _push(`</div>`);
    _push(ssrRenderComponent(_component_modal_services, {
        onTogglemodal: $options.openservicemodal,
        locale: $data.locale,
        style: $data.showmodal ? null : { display: "none" },
        authenticated: $data.authenticated,
        key: $data.userservices.length,
        userservices: $data.userservices,
        currentroom: $data.currentroom
    }, null, _parent));
    _push(`</section><br><!--]-->`);
}
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
    const ssrContext = useSSRContext();
    (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/MessageIndex.vue");
    return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const MessageIndex = /* @__PURE__ */ _export_sfc(_sfc_main, [
    ["ssrRender", _sfc_ssrRender]
]);
const app = createApp(MessageIndex);
app.mount("#app");
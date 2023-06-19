<template>
    <div id="modal-wrapper">

        <div class="modal_section" :key="selectedservice.id">
            <div class="w-100 right"><span class="cancel_icon" @click="$emit('togglemodal')"><i
                        class="las la-times"></i></span>
            </div>
            <div v-if="selectedservice.id">
                <div class="w-100"><span class="cancel-icon" @click="resetserviceselected()"><i
                            class="las la-arrow-left"></i></span> &nbsp; {{ translated('allservices') }}</div>
                <div class="modal_content">
                    <div class="w-100 center margin-y-10">
                        <h2 class="service_title">{{ translated('service_title') }}</h2>
                    </div>
                    <div class="w-100 left">
                        <h4 class="service_name">{{ translated('name', selectedservice.name) }}</h4>
                    </div>

                    <div class="w-100 justify">
                        <div class="clumn column-40">
                            <div class="form-group">
                                <label></label>
                                <div class="form-control">
                                    <input type="number" placeholder=" €" name="price" v-model="selectedservice.price" />
                                    <span class="inputsymbol">€</span>
                                </div>
                            </div>
                        </div>
                        <div class="column column-60">
                            <button
                                @click="createandwritelink(currentroom.sender_id, currentroom.receiver_id, selectedservice.code, locale, 'created_link')"
                                class="create_link">
                                <i class="las la-link"></i>{{ translated('createlink') }}
                            </button>
                        </div>
                    </div>
                    <div class="w-100 center" :class="{ 'd-none': createdLink == '' }" id="created_link">
                        <div v-html="createdLink" class="created_link"></div> <span class="copy_button"
                            @click="copyelement('created_link', 'copy_button')"><i class="las la-clipboard"></i></span>
                    </div>
                    <div class="w-100 center" :class="{ 'd-none': createdLink == '' }">
                        <button
                            @click="sendmessage"
                            class="create_link">
                            <i class="las la-paper-plane"></i> Send
                        </button>
                    </div>
                </div>
            </div>
            <div v-else>
                <form style="height:50px;" class="row" @submit="searchnow">
                    <div class="form-group">
                        <input type="text" v-model="searching" @keyup="searchnow" class="form-control" name="search"
                            :placeholder="translated('search')" style="width:85%" />
                    </div>
                </form>
                <div class="message_elements_area" v-if="userservices_val.length > 0">

                    <div class="service_element_on_modal" v-for="(service, index) in userservices_val" :key="index">
                        <div class="image">
                            <img :src="service.images[0] != null ? '/temp/' + service.images[0].original_images : '/assets/images/no-user.png'"
                                :alt="service.name.az_name" />
                        </div>
                        <div class="info">
                            <h3>{{ translated('name', service.name) }}

                            </h3>
                        </div>
                        <div class="right">
                            <button @click="selectservice(service)" class="buttonselect">{{ translated('choise') }}</button>
                        </div>
                    </div>
                </div>

                <div class="row text-center" v-else>
                    <p class="text-center text-danger">{{ translated("null") }}</p>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props: ['currentroom', 'authenticated', 'locale', 'userservices'],
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
                    createlink: "Ödəniş linkini yarat",
                },
                ru: {
                    search: "Поиск",
                    choise: "выбирать",
                    null: "Нет информации",
                    allservices: "Все услуги",
                    service_title: "Общая информация об услуге",
                    price: "Цена",
                    createlink: "Создать платежную ссылку",
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
            searching: '',
            price: '',
            userservices_val: [],
            createdLink: '',
        };
    },
    methods: {
        translated(type, data = null) {
            if (this.locale === 'az') {
                if (data != null) {
                    if (type == "name") {

                        return data.az_name;
                    } else if (type == "description") {
                        return data.az_description;
                    }
                } else {
                    return this.translations.az[type];
                }
            } else if (this.locale === 'ru') {
                if (data != null) {
                    if (type == "name") {
                        return data.ru_name;
                    } else if (type == "description") {
                        return data.ru_description;
                    }
                } else {
                    return this.translations.ru[type];
                }
            } else if (this.locale === 'en') {
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
            axios.get('/api/services_user/' + this.currentroom.sender_id + '/' + this.searching)
                .then(response => {
                    this.userservices_val = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        getsubstr(value, length = 10) {
            if (!value) return '';
            if (value.length <= length) return value;
            return value.substring(0, length) + '...';
        },
        selectservice(service) {
            this.selectedservice = service;
        },
        resetserviceselected() {
            this.selectedservice = [];
            this.createdLink = '';
        },
        createandwritelink(sender_id, receiver_id, service_id, language = "az", classofarea) {
            this.createdLink = '';
            axios.get('/api/createupayment?sender_id=' + sender_id + '&receiver_id=' + receiver_id + '&service_id=' + service_id + '&price=' + this.selectedservice.price + '&language=' + language + '')
                .then(response => {
                    this.createdLink = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        copyelement(copyelement, copybutton) {
            var element = document.querySelector('div.' + copyelement).textContent;
            navigator.clipboard.writeText(element);
            var button = document.querySelector('span.' + copybutton);
            button.innerHTML = '<i class="las la-check-circle"></i>';
            button.classList.add('active');
            setTimeout(function () {
                button.innerHTML = '<i class="las la-clipboard"></i>';
                button.classList.remove("active");
            }, 1500);
        },
        sendmessage() {
            if (this.createdLink == ' ') {
                return;
            }
            axios.post('/sendmessage/' + this.currentroom.id, { message: this.createdLink }).then(response => {
                if (response.status == 201) {
                    this.createdLink = '';
                    this.$emit('sendmessage');
                    this.$emit('togglemodal')
                }
            }).catch(error => console.log(error));
        },
    },
    mounted() {
        this.userservices_val = this.userservices;
    },
    created() {
        this.userservices_val = this.userservices
    },

}
</script>

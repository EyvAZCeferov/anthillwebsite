<template>
    <section>
        <div class="container" :key="newmessage.length">
            <div class="w-100 row message_lists" v-if="users.length > 0">
                <div class="message_left_column">
                    <message-list :authenticated="authenticated[0]" :users="users" :locale="locale"
                    :messages="messages"
                        :currentroom="currentroom" v-on:roomchanged="setRoom($event)"></message-list>
                </div>
                <div class="message_right_column" v-if="currentroom.id">
                    <messages-container :authenticated="authenticated[0]" :messages="messages" :locale="locale"
                        @readedMessage="getAllData($event)" :currentroom="currentroom"></messages-container>
                    <messages-attributes v-if="currentroom.senderinfo.id != authenticated[0].id"
                        :authenticated="authenticated[0]" :currentroom="currentroom" :attributes="attributes"
                        :locale="locale" @sendmessage="getAllData"></messages-attributes>
                    <message-input :currentroom="currentroom" :authenticated="authenticated[0]" :locale="locale"
                        @showmodalsendlink="openservicemodal" @sendmessage="getAllData"></message-input>
                </div>
                <div class="row w-100 message_right_column message_center_show_alert" v-else>
                    <p class="text-center text-danger">Select the user from the left.</p>
                </div>
            </div>


            <div class="row w-100 message_center_show_alert" v-else>
                <p class="text-center text-danger">You have no messages.</p>
            </div>

        </div>
        <modal-services @togglemodal="openservicemodal" @sendmessage="getAllData" :locale="locale" v-show="showmodal"
            :authenticated="authenticated" :userservices="userservices"
            :currentroom="currentroom"></modal-services>
    </section>
    <br />
</template>

<script>
import MessageList from './MessageList.vue';
import MessagesContainer from './MessagesContainer.vue';
import MessageInput from './MessageInput.vue';
import ModalServices from './ModalServices.vue';
import MessagesAttributes from './MessagesAttributes.vue';
import {connectecho} from '../getmessagecount';

export default {
    components: {
        MessageList,
        MessagesContainer,
        MessageInput,
        ModalServices,
        MessagesAttributes,
    },
    data() {
        return {
            users: [],
            currentroom: [],
            messages: [],
            locale: 'az',
            authenticated: [],
            showmodal: false,
            userservices: [],
            attributes: [],
            newmessage:0,
        };
    },
    watch: {
        currentroom(val, oldval) {
            if (oldval != null && oldval.id) {
                this.disconnect(oldval);
            }
            this.connect();
        },
    },
    methods: {
        connect() {
            if (this.currentroom.id) {
                let vm = this;
                window.Echo.private('chat.' + this.currentroom.id).listen('NewChatMessage', (e) => {
                    vm.newmessage++;
                    connectecho();
                    vm.getAllData();
                });
            }
        },
        disconnect(room) {
            if (room != null && room.id) {
                window.Echo.leave('chat.' + room.id);
                this.newmessage=0;
            }
        },
        getUsers() {
            axios.get('/fetchmessagegroups').then(response => {
                this.users = response.data.data;
                const createdViaId = this.getCreatedViaId();
                if (createdViaId) {
                    this.currentroom = this.users.find(user => user.sender_id === parseInt(createdViaId));
                    this.setRoom(this.currentroom)
                }
            }).catch(error => console.error(error));
        },
        setRoom(userone) {
            this.currentroom = Object.assign({}, userone);
            this.getMessagesFromRoom();
            this.getAttributes();
        },
        getMessagesFromRoom() {
            axios.get('/fetchmessages/' + this.currentroom.id).then(response => {
                this.messages = response.data.data;
            }).catch(error => console.log(error));
        },
        getLocale() {
            axios.get('/locale')
                .then(response => {
                    this.locale = response.data.locale;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        getAllData() {
            this.getUsers();
            this.setRoom(this.currentroom);
            this.countmessages();
        },
        getauthenticated() {
            axios.get('/authenticated')
                .then(response => {
                    this.authenticated = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        openservicemodal() {
            this.showmodal = !this.showmodal;
            this.userservices = [];
            if (this.showmodal == true) {
                axios.get('/api/services_user/' + this.currentroom.sender_id)
                    .then(response => {
                        this.userservices = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        getCreatedViaId() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('createdvia');
        },
        getAttributes() {
            if (this.currentroom != null && this.currentroom.product_id != null && this.currentroom.product_id) {
                axios.get('/fetchattributes/' + this.currentroom.product_id).then(response => {
                    this.attributes = response.data.data;
                }).catch(error => console.log(error));
            }
        },
        countmessages() {
            var notreadedmessages = 0;
            axios
                    .post('/notreadedmessages')
                    .then(response => {
                        notreadedmessages+=response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            return notreadedmessages;
        }
    },
    created() {
        this.getauthenticated();
        this.getLocale();
        this.getUsers();
        this.getCreatedViaId();
        this.countmessages();
    },
    // updated() {
    //     this.getUsers();
    //     this.countmessages();
    // },
}
</script>

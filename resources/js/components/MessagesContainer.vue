<template>
    <div class="message_containers">
        <div class="receiver_area" @click="redirectToCompany(currentroom.senderinfo.additionalinfo.company_slugs)" v-if="authenticated && authenticated.type==1">
            <div class="photo">
                <img :src="currentroom.senderinfo.additionalinfo != null && currentroom.senderinfo.additionalinfo.company_image != null ? '/temp/' + currentroom.senderinfo.additionalinfo.company_image : '/assets/images/no-user.png'"
                    alt="currentroom.senderinfo.name_surname" />
            </div>
            <div class="info">
                <h5>{{ currentroom.senderinfo.type == 1 ? currentroom.senderinfo.name_surname :
                    currentroom.senderinfo.additionalinfo.company_name.az_name }}
                </h5>
            </div>
        </div>
        <div class="receiver_area" @click="redirectToCompany(currentroom.receiverinfo.additionalinfo.company_slugs)" v-else>
            <div class="photo">
                <img :src="currentroom.receiverinfo.additionalinfo != null && currentroom.receiverinfo.additionalinfo.company_image != null ? '/temp/' + currentroom.receiverinfo.additionalinfo.company_image : '/assets/images/no-user.png'"
                    alt="currentroom.receiverinfo.name_surname" />
            </div>
            <div class="info">
                <h5>{{ currentroom.receiverinfo.type == 1 ? currentroom.receiverinfo.name_surname :
                    currentroom.receiverinfo.additionalinfo.company_name.az_name }}
                </h5>
            </div>
        </div>
        <div class="message_elements_area">
            <div v-for="(message, index) in messages" :key="index"
                :class="{ 'message-element': true, 'sender': message.user_id == authenticated.id }">
                <div class="message-content">
                    <template v-if="isURL(message.message)">
                        <a :href="message.message" target="_blank">{{ message.message }}</a>
                      </template>
                      <template v-else>
                        {{ message.message }}
                      </template>
                </div>
                <div class="time">{{ formatDate(message.created_at) }}</div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    props: [
        'currentroom',
        'messages',
        'locale',
        'authenticated'
    ],
    methods: {
        formatDate: function (value) {
            dayjs.locale(this.locale)
            if (value) {
                return dayjs(value).fromNow();
            }
        },
        readedMessage(message) {
            if (message.status == false) {
                axios
                    .post('/readmessage/' + message.id)
                    .then(response => {
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        redirectToCompany(slugs){
            var url;
            if(this.locale=="az"){
                url=`/company/${slugs.az_slug}`;
            }else if(this.locale=="ru"){
                url=`/company/${slugs.ru_slug}`;
            }else if(this.locale=="en"){
                url=`/company/${slugs.en_slug}`;
            }
            window.open(url, '_blank');
        },
        isURL(str) {
            try {
                new URL(str);
                return true;
            } catch (error) {
                return false;
            }
        },
    },
    updated() {
        this.messages.forEach(message => {
            if(message.status==false && message.user_id!=this.authenticated[0].id){
                this.readedMessage(message);
            }
        });
    },

    mounted() {
        this.messages.forEach(message => {
            if(message.status==false && message.user_id!=this.authenticated[0].id){
                this.readedMessage(message);
            }
        });
    },

}
</script>

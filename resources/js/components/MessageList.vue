<template>
    <div v-for="userone in users" class="message_left_element" @click="$emit('roomchanged', userone)">
        <div class="image" v-if="authenticated && authenticated.type==3">
            <img :src="userone.receiverinfo.additionalinfo != null && userone.receiverinfo.additionalinfo.company_image != null ? '/temp/' + userone.receiverinfo.additionalinfo.company_image : '/assets/images/no-user.png'"
                :alt="userone.receiverinfo.name_surname" />
        </div>
        <div class="image" v-else>
            <img :src="userone.senderinfo.additionalinfo != null && userone.senderinfo.additionalinfo.company_image != null ? '/temp/' + userone.senderinfo.additionalinfo.company_image : '/assets/images/no-user.png'"
                :alt="userone.senderinfo.name_surname" />
        </div>
        <div class="content">
            <div class="info">
                <h5 class="name" v-if="authenticated && authenticated.type==3">
                    {{ userone.receiverinfo.type == 1 ? userone.receiverinfo.name_surname :
                        userone.receiverinfo.additionalinfo.company_name.az_name }}
                </h5>
                <h5 class="name" v-else>
                    {{ userone.senderinfo.type == 1 ? userone.senderinfo.name_surname :
                        userone.senderinfo.additionalinfo.company_name.az_name }}
                </h5>
                <p v-if="userone.message_elements && userone.message_elements.length > 0" class="description">{{
                    getsubstr(userone.message_elements[0].message, 40) }}</p>
            </div>
        </div>
        <div class="right-section" v-if="userone.message_elements.length > 0">
            <div class="date">{{ formatDate(userone.message_elements[0].created_at) }}</div>

            <div class="status">
                <span v-if="userone.message_elements[0].status == 0" class="badge">{{
                    countmessages(userone.message_elements) }}</span>
                <span v-else><i class="las la-check-double"></i></span>
            </div>
        </div>

    </div>
</template>

<script>


export default {
    props: ['users', 'currentroom', 'locale', 'authenticated'],
    data: function () {
        return {
            selected: ''
        }
    },
    methods: {
        getsubstr(value, length = 10) {
            if (!value) return '';
            if (value.length <= length) return value;
            return value.substring(0, length) + '...';
        },
        formatDate: function (value) {
            dayjs.locale(this.locale)
            if (value) {
                return dayjs(value).fromNow();
            }
        },
        countmessages(messages) {
            var notreadedmessages = 0;
            for (var i = 0; i < messages.length; i++) {
                notreadedmessages += (messages[i].status === false) ? 1 : 0;
            }
            return notreadedmessages;
        }
    },
    created() {
        this.selected = this.currentroom;
    }
}

</script>

<template>
    <div class="message_input_area">
        <div class="form-group">
            <span v-if="authenticated.type == 3 ? true : false" class="link" @click="$emit('showmodalsendlink')"><i
                    class="las la-link"></i></span>
            <input class="form-control" v-model="message" @keyup.enter="sendmessage()" placeholder="Write your message" />
        </div>
        <button class="send_message"><i class="las la-paper-plane" @click="sendmessage()"></i></button>
    </div>
</template>

<script>
export default {
    props: ['currentroom', 'authenticated'],
    data() {
        return {
            message: '',
        };
    },
    methods: {
        sendmessage() {
            if (this.message.trim() === '') {
                return;
            }
            axios.post('/sendmessage/' + this.currentroom.id, { message: this.message }).then(response => {
                if (response.status == 201) {
                    this.message = '';
                    this.$emit('sendmessage');
                }
            }).catch(error => console.log(error));
        },
    }
}
</script>

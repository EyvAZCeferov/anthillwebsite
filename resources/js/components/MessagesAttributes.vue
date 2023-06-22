<template>
    <button @click="changevisibility()" class="visibility">Services</button>
    <div class="message_attributes">
        <div v-if="showattributes" v-for="(attributeel, index) in attributes" :key="index" class="message_attribute"
            @click="sendmessage(`${attributeel.attribute.group.name.en_name}: ${attributeel.attribute.name.en_name}${attributeel.attribute.group.datatype === 'price' ? ' €' : ''}`)">
            {{ attributeel.attribute.group.name.en_name }}: {{ attributeel.attribute.name.en_name }}
            <span v-if="attributeel.attribute.group.datatype === 'price'" class="price">€</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['currentroom', 'attributes'],
    data() {
        return {
            message: '',
            showattributes: false,
        }
    },
    methods: {
        sendmessage(message) {
            this.message = message;
            if (this.message.trim() === '') {
                return;
            }
            axios.post('/sendmessage/' + this.currentroom.id, { message: this.message })
                .then(response => {
                    if (response.status === 201) {
                        this.message = '';
                        this.$emit('sendmessage');
                    }
                })
                .catch(error => console.log(error));
        },
        changevisibility() {
            this.showattributes = !this.showattributes;
        }
    }
}
</script>

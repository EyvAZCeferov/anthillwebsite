<template>
    <div class="message_attributes">
        <div v-for="(attributeel, index) in attributes" :key="index" class="message_attribute"
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
    },
    created(){
        console.log(this.attributes);
        console.log(this.attributes.length);
    },
    updated(){
        console.log(this.attributes);
        console.log(this.attributes.length);
    }
}
</script>

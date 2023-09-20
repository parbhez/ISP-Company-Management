<template>
    <div>
        <label for="phone">name:</label>
        <input
            id="name"
            type="text"
            v-model="formData.name"
            placeholder="Enter your name"
        />

        <label for="phone">Email:</label>
        <input
            id="email"
            type="email"
            v-model="formData.email"
            placeholder="Enter your Email"
        />

        <label for="phone">Customer Number:</label>
        <input
            id="phone"
            type="tel"
            v-model="formData.customer_phone"
            placeholder="Enter your Customer phone number"
        />

        <label for="address">Address:</label>
        <textarea
            id="address"
            v-model="formData.address"
            placeholder="Enter your address"
        ></textarea>

        
    </div>
</template>

<script>
export default {
    props: {
        formData: {
            type: Object,
            required: true,
        },
    },
    methods: {
        // Emit the event to indicate the "Next" button is clicked
        emitNextStepEvent() {
            this.$emit("next-step-clicked");
        },
    },
};
</script>

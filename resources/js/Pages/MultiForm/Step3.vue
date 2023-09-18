<template>
    <div>
        <label for="address">Address:</label>
        <textarea
            id="address"
            v-model="formData.address"
            placeholder="Enter your address"
        ></textarea>

        <label for="phone">Phone Number:</label>
        <input
            id="phone"
            type="tel"
            v-model="formData.phone"
            placeholder="Enter your phone number"
        />
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

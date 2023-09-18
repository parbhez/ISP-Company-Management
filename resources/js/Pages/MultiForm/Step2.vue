<template>
    <div>
        <label for="name">User Name:</label>
        <input
            id="name"
            type="text"
            v-model="formData.name"
            placeholder="Enter your user name"
        />

        <label for="email">Email:</label>
        <input
            id="email"
            type="email"
            v-model="formData.email"
            placeholder="Enter your email"
        />

        <label for="password">Password:</label>
        <input
            id="password"
            type="password"
            v-model="formData.password"
            placeholder="Enter your password"
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

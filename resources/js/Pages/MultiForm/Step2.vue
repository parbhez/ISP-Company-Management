<template>
    <div>
        <label for="name">Select Phone Number:</label>
        <select name="phone_number" id="phone_number" v-model="formData.phone_number">
            <option :value="number" v-for="(number, key) in numberList" :key="key">{{ number }}</option>
        </select>

        
    </div>
</template>

<script>
export default {
    props: {
        formData: {
            type: Object,
            required: true,
        },
        numberList: {
            type: Array,
            required: true
      }
    },
    methods: {
        // Emit the event to indicate the "Next" button is clicked
        emitNextStepEvent() {
            this.$emit("next-step-clicked");
        },
    },
};
</script>

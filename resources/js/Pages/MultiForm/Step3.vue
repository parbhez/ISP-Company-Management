<template>
    <div>
        <label for="name">Select Plan:</label>
        <select name="plan" id="plan" v-model="formData.plan">
            <option :value="plan" v-for="(plan, key) in planList" :key="key">{{ plan }}</option>
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
    },

    data(){
        return {
            planList: ['$10.00', '$9.99']
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

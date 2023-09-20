<template>
    <div>
      <label for="firstName">Area Code:</label>
      <input id="firstName" type="text" v-model="formData.area_code" placeholder="Enter your Area code" />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      formData: {
        type: Object,
        required: true
      }
    },
    methods: {
      // Emit the event to indicate the "Next" button is clicked
      emitNextStepEvent() {
        this.$emit('next-step-clicked');
      }
    }
  };
  </script>
  
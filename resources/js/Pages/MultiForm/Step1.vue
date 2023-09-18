<template>
    <div>
      <label for="firstName">First Name:</label>
      <input id="firstName" type="text" v-model="formData.firstName" placeholder="Enter your first name" />
  
      <label for="lastName">Last Name:</label>
      <input id="lastName" type="text" v-model="formData.lastName" placeholder="Enter your last name" />
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
  
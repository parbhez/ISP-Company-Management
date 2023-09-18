<template>
    <div>
      <form @submit.prevent="submitForm">
        <component
          :is="currentStepComponent"
          v-on:form-next-step="nextStep"
          :form-data="formData"
        />
        <button v-if="currentStep > 0" @click.prevent="prevStep">Back</button>
        <button v-if="showNextButton" @click.prevent="nextStep">Next</button>
        <button v-else type="submit">Submit</button>
      </form>
    </div>
  </template>
  
  <script>
  import Step1 from './Step1.vue';
  import Step2 from './Step2.vue';
  import Step3 from './Step3.vue';
  
  export default {
    components: {
      Step1,
      Step2,
      Step3,
    },
    data() {
      return {
        currentStep: 0,
        steps: ['Step1', 'Step2', 'Step3'],
        formData: {
          firstName: '',
          lastName: '',
          name: '',
          email: '',
          password: '',
          address: '',
          phone: '',
        },
      };
    },
    computed: {
      currentStepComponent() {
        return this.steps[this.currentStep];
      },
      showNextButton() {
        // Show "Next" button only on Step1 and Step2, not on Step3
        return this.currentStep < this.steps.length - 1;
      },
    },
    methods: {
      nextStep() {
        if (this.currentStep < this.steps.length - 1) {
          this.currentStep++;
        } else {
          this.submitForm();
        }
      },
      prevStep() {
        if (this.currentStep > 0) {
          this.currentStep--;
        }
      },


      async submitForm() {
        await axios
        .post('/multi-step-submit-form', this.formData)
        .then((response) => {
        console.log(response.data);
          // Reset form data after successful submission
          this.formData = {
            firstName: '',
            lastName: '',
            name: '',
            email: '',
            password: '',
            address: '',
            phone: '',
          };
          this.currentStep = 0; // Reset step to the first step
        })
        .catch((error) => {
          console.error('Error submitting form:', error);
        });
           
      },
    },
  };
  </script>
  
<template>
    <div class="col-md-12">
        <div class="form-group">
  <label>{{ label }} <span :style="styleObject">*</span></label>
   <select
       v-bind="$attrs"
       :placeholder="placeholder"
       class="form-control"
       rows="4"
       :value="modelValue"
       @input="$emit('update:modelValue', $event.target.value)"
       style="margin-top: 10px;"
   ></select>
</div>
</div>
</template>

<script>
   export default {
       props:{
           label:{
               type: String,
               defautl: ''
           },
           placeholder:{
               type: String,
               defautl: ''
           },
           modelValue:{
               type: [String, Number],
               default: ''
           },
           mandatory: {
            type: String,
            default: "show",
        },
       },
       data() {
        return {
            styleObject: {
                color: "red",
                display: this.mandatory,
            },
        };
    },
   }
</script>

<template>
    <div class="col-md-12">
        <div class="form-group">
            <label
            style="color:#b6bbc5;"
                >{{ label }}
                <span :style="styleObject"
                    >*</span
                ></label
            >
            <input
                v-bind="$attrs"
                :placeholder="placeholder"
                class="form-control"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                style="margin-top: 10px"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            defautl: "",
        },
        placeholder: {
            type: String,
            defautl: "",
        },
        modelValue: {
            type: [String, Number],
            default: "",
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
};
</script>

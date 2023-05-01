<template>
    <div class="col-md-12">
        <div class="form-group">
            <select
                :name="name"
                :id="id"
                class="form-select"
                aria-label="Default select example"
            >
                <slot></slot>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            defaut: "",
        },
        id: {
            type: String,
            defaut: "",
        },
        // modelValue: {
        //     type: [String, Number],
        //     default: "",
        // },
    },
};
</script>

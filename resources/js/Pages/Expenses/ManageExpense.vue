<template>
    <AppLayout title="Dashboard">
        <section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">All Expense</h5>
                        </div>
                        <div class="col-md-6 text-ri text-right">
                            <button
                                :data-target="'#' + modal_name"
                                v-if="userWiseRolePermission.includes('expense.create')"
                                data-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap"
                                @click.prevent="beforeOpen"
                            >
                                Add New Expense
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    class="card-body table-responsive"
                    style="margin-top: -60px"
                >
                    <!-- <overlay-preloader :action="preload"></overlay-preloader> -->
                    <list-preloader :action="preload"></list-preloader>
                    <div class="px-2 py-1 mt-0">
                        <v-table-head
                            :meta="meta"
                            @changed="pageChange"
                            @search="applySearch"
                        ></v-table-head>
                    </div>

                    <div
                        class="dt-row-grouping table table-bordered"
                        :class="preload ? 'loader-secondary' : ''"
                    >
                        <v-simple-table
                            :headers="[
                                '#SL.',
                                'Expense Name',
                                'Date',
                                'Description',
                                'Amount',
                                'Actions',
                            ]"
                        >
                            <tr v-for="(expense, key) in expenseList" :key="key">
                                <td>
                                    {{
                                        meta.per_page *
                                            (meta.current_page - 1) +
                                        (key + 1)
                                    }}
                                </td>
                                <td>
                                    <span> {{ expense.name }} </span>
                                </td>

                                <td>
                                    <span> {{ expense.date }} </span>
                                </td>

                                <td>
                                    <span> {{ expense.description }} </span>
                                </td>

                                <td>
                                    <span> {{ expense.amount }} </span>
                                </td>

                                <td class="align-middle">
                                    <button
                                        type="button"
                                        v-if="userWiseRolePermission.includes('expense.edit')"
                                        class="btn btn-primary btn-sm mr-2"
                                        @click.prevent="
                                            onClickHandleAction('edit', expense)
                                        "
                                    >
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        </v-simple-table>
                        <not-found
                            class="py-5"
                            v-if="expenseList.length == 0"
                            :message="
                                loading
                                    ? 'Loading...'
                                    : 'Oops..! No data available in the system.'
                            "
                        ></not-found>
                    </div>

                    <div class="p-2 mt-3">
                        <v-paginate
                            v-if="expenseList.length > 0"
                            :offset="5"
                            :meta="meta"
                            @changed="pageChange"
                        ></v-paginate>
                    </div>
                </div>
            </div>

           <!--Role Modal start-->
           <div
                class="modal fade"
                :id="modal_name"
                tabindex="-1"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">
                                {{ modal_title }} Expense
                            </h3>
                            <button
                                type="button"
                                class="close rounded-pill"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Add role form -->
                            <form class="form">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Expense Name</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Expense Name"
                                                    v-model="form.name"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Date</label
                                                >
                                                <input
                                                    type="date"
                                                    class="form-control"
                                                    v-model="form.date"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Description</label
                                                >
                                                <textarea class="form-control" v-model="form.description" placeholder="Expense Description"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Amount</label
                                                >
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="Expense Amount"
                                                    v-model="form.amount"
                                                />
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </form>
                            <!--/ Add role form -->
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-light-secondary"
                                data-dismiss="modal"
                            >
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary ml-1"
                                data-dismiss="modal"
                                :class="isLoading(loading)"
                                :disabled="loading"
                                @click.prevent="onSubmitForm"
                            >
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">
                                    {{ button_name }}</span
                                >
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Role Modal End-->
        </section>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Expenses } from "../../core/endpoints";
export default {
    components: {
        AppLayout,
    },
    props: {
        all_expenses: {
            type: Object,
            default: {},
        },

    },

    data() {
        return {
            modal_name: "expense-modal",
            modal_title: "",
            button_name: "",
            fetchable: "fetchExpenses",
            filterable: "filters",
            expenseList: [],
            preload: false,
            meta: {},
            loading: false,
            id: null,
            form: this.initForm(),
            userWiseRolePermission:[]
        };
    },

    mounted() {
        this.fetchExpenses();
        //console.log(this.all_permissions);
        this.$store.dispatch('getRoleWisePermissionList')
        .then((response)=>{
            // console.log(response.roleWisePermissionList);
            var all_permissions = response.roleWisePermissionList;
            all_permissions.forEach((item,index)=>{
                this.userWiseRolePermission.push(item.name);
            })
            // console.log(this.userWiseRolePermission)
        });
    },

    watch: {

    },

    computed: {

    },

    methods: {
        beforeOpen() {
            this.modal_title = "Add";
            this.button_name = "Save";
            this.form = this.initForm();
        },

        async onSubmitForm() {
            //return console.log(this.form.name);
            try {
                this.loading = true;
                this.preload = true;
                let formId = parseInt(this.id);
                // return console.log(this.form);

                let { data } = await axios[!this.id ? "post" : "put"](
                    !this.id ? `${Expenses}` : `${Expenses}/${formId}`,
                    this.form
                );
                //return console.log(data)
                this.updateState(data.data, "expenseList", this.id);
                $("#" + this.modal_name).modal("hide");
                toastr.success(
                    `${this.id ? data.message : data.message}`,
                    "Great!"
                );
                this.loading = false;
                this.preload = false;
            } catch (error) {
                //return console.log(error);
                $("#" + this.modal_name).modal("hide");
                this.setFormErrors(error);
                toastr.error("Failed to create Permission!", "Opps!");
                this.loading = false;
                this.preload = false;
            }
        },

        async fetchExpenses() {
            this.preload = true;
            let { data } = await axios.get(
                `expense/lists${this.getURLQueryString()}`
            );
            //console.log(data.data)
            this.expenseList = data.data;
            this.meta = data.meta;
            this.preload = false;
        },
        initForm() {
            return {
                name: null,
                date: null,
                description: null,
                amount: null,
                status: 1,
            };
        },
    },
};
</script>

<style scoped>
label {
    text-transform: capitalize !important;
    font-size: 14px !important;
}
.checkbox label {
    font-size: 13px !important;
}
</style>

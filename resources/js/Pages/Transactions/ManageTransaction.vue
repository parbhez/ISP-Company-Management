<template>
    <AppLayout title="Dashboard">
        <section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">All Transaction</h5>
                        </div>
                        <div class="col-md-6 text-ri text-right" v-for="(checkPermission, key) in getRoleWisePermissionList" :key="checkPermission.id">
                            <div v-if="checkPermission.name == 'transaction.create'">
                            <button
                                :data-target="'#' + modal_name"
                                data-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap"
                                @click.prevent="beforeOpen"
                            >
                                Add New Transaction
                            </button>
                            </div>
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
                                'Account Number',
                                'Type',
                                'Date',
                                'Amount',
                                'Description',
                            ]"
                        >
                            <tr v-for="(transaction, key) in transactionList" :key="key">
                                <td>
                                    {{
                                        meta.per_page *
                                            (meta.current_page - 1) +
                                        (key + 1)
                                    }}
                                </td>
                                <td>
                                    <span> {{ transaction.account_number }} </span>
                                </td>

                                <td>
                                    <span> {{ transaction.type }} </span>
                                </td>

                                <td>
                                    <span> {{ transaction.date }} </span>
                                </td>

                                <td>
                                    <span> {{ transaction.amount }} </span>
                                </td>

                                <td>
                                    <span> {{ transaction.description }} </span>
                                </td>


                            </tr>
                        </v-simple-table>
                        <not-found
                            class="py-5"
                            v-if="transactionList.length == 0"
                            :message="
                                loading
                                    ? 'Loading...'
                                    : 'Oops..! No data available in the system.'
                            "
                        ></not-found>
                    </div>

                    <div class="p-2 mt-3">
                        <v-paginate
                            v-if="transactionList.length > 0"
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
                                {{ modal_title }} Transaction
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
                                                    >Account Number</label
                                                >
                                                <select v-model="form.account_id" class="form-control">
                                                    <option selected disabled>Select Any One</option>
                                                    <option :value="account.id" v-for="(account, key) in all_accounts" :key="key">{{ account.account_number }}</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Transaction Date</label
                                                >
                                                <input
                                                    type="date"
                                                    class="form-control"
                                                    placeholder="Accountant Name"
                                                    v-model="form.date"
                                                />
                                            </div>
                                        </div>



                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Transaction Type</label
                                                >
                                                <select v-model="form.type" class="form-control">
                                                    <option selected disabled value="">Select Transaction Type</option>
                                                    <option value="Deposit">Deposit</option>
                                                    <option value="Withdraw">Withdraw</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Transaction Amount</label
                                                >
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    placeholder="Transaction Amount"
                                                    v-model="form.amount"
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
                                                <textarea

                                                class="form-control"
                                                v-model="form.description"
                                                placeholder="Description"
                                                ></textarea>
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
import { Transactions } from "../../core/endpoints";
export default {
    components: {
        AppLayout,
    },
    props: {
        all_transaction: {
            type: Object,
            default: {},
        },

        all_accounts: {
            type: Object,
            default: {},
        },

    },

    data() {
        return {
            modal_name: "transaction-modal",
            modal_title: "",
            button_name: "",
            fetchable: "fetchTransactions",
            filterable: "filters",
            transactionList: [],
            preload: false,
            meta: {},
            loading: false,
            id: null,
            form: this.initForm(),
        };
    },

    mounted() {
        this.fetchTransactions();
        //console.log(this.all_accounts);
        this.$store.dispatch('getRoleWisePermissionList');
    },

    watch: {

    },

    computed: {
        getRoleWisePermissionList(){
            return this.$store.getters.roleWisePermissionList;
        },
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
                    !this.id ? `${Transactions}` : `${Transactions}/${formId}`,
                    this.form
                );
                //return console.log(data)
                this.updateState(data.data, "transactionList", this.id);
                $("#" + this.modal_name).modal("hide");
                toastr.success(
                    `${this.id ? data.message : data.message}`,
                    "Great!"
                );
                this.fetchTransactions();
                this.loading = false;
                this.preload = false;
            } catch (error) {
                //return console.log(error);
                $("#" + this.modal_name).modal("hide");
                this.setFormErrors(error);
                toastr.error("Failed to create account!", "Opps!");
                this.loading = false;
                this.preload = false;
            }
        },

        async fetchTransactions() {
            this.preload = true;
            let { data } = await axios.get(
                `transaction/lists${this.getURLQueryString()}`
            );
            //console.log(data.data)
            this.transactionList = data.data;
            this.meta = data.meta;
            this.preload = false;
        },
        initForm() {
            return {
                name: null,
                account_number: this.presentAccountNumber ?? null,
                type: null,
                description: null,
                balance: null,
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

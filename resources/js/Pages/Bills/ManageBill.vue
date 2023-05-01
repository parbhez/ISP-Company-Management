<template>
    <AppLayout title="Dashboard">
        <section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">All Bills</h5>
                        </div>
                        <div class="col-md-6 text-ri text-right" v-for="(checkPermission, key) in getRoleWisePermissionList" :key="checkPermission.id">
                            <div v-if="checkPermission.name == 'bill.create'">
                            <button
                                :data-target="'#' + modal_name"
                                data-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap"
                                @click.prevent="beforeOpen"
                            >
                                Add New Bill
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
                                'Customer Name',
                                'Month',
                                'Year',
                                'Bill Amount',
                                'Status',
                                'Actions',
                            ]"
                        >
                            <tr v-for="(bill, key) in billList" :key="key">
                                <td>
                                    {{
                                        meta.per_page *
                                            (meta.current_page - 1) +
                                        (key + 1)
                                    }}
                                </td>
                                <td>
                                    <span> {{ bill.customer_name }} </span>
                                </td>

                                <td>
                                    <span> {{ bill.month }} </span>
                                </td>

                                <td>
                                    <span> {{ bill.year }} </span>
                                </td>

                                <td>
                                    <span> {{ bill.amount }} </span>
                                </td>

                                <td>
                                    <span :class="statusColor(bill.status)"> {{ bill.status }} </span>
                                </td>

                                <td class="align-middle">
                                    <div v-for="(checkPermission, key) in getRoleWisePermissionList" :key="checkPermission.id">
                                    <button
                                        type="button"
                                        v-if="checkPermission.name == 'bill.edit'"
                                        class="btn btn-primary btn-sm mr-2"
                                        @click.prevent="
                                            onClickHandleAction('edit', bill)
                                        "
                                    >
                                        Edit
                                    </button>
                                </div>
                                </td>
                            </tr>
                        </v-simple-table>
                        <not-found
                            class="py-5"
                            v-if="billList.length == 0"
                            :message="
                                loading
                                    ? 'Loading...'
                                    : 'Oops..! No data available in the system.'
                            "
                        ></not-found>
                    </div>

                    <div class="p-2 mt-3">
                        <v-paginate
                            v-if="billList.length > 0"
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
                                {{ modal_title }} Bill
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
                                                    >Month</label
                                                >
                                                <select v-model="form.month" class="form-control">
                                                    <option selected disabled value="">Select Any One</option>
                                                    <option value="January">January</option>
                                                    <option value="February">February</option>
                                                    <option value="March">March</option>
                                                    <option value="April">April</option>
                                                    <option value="May">May</option>
                                                    <option value="June">June</option>
                                                    <option value="July">July</option>
                                                    <option value="August">August</option>
                                                    <option value="September">September</option>
                                                    <option value="October">October</option>
                                                    <option value="November">November</option>
                                                    <option value="December">December</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Year</label
                                                >
                                                <select v-model="form.year" class="form-control">
                                                    <option selected disabled value="">Select Any One</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2025">2025</option>
                                                    <option value="2026">2026</option>


                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Customer</label
                                                >
                                                <select v-model="form.customer_id" class="form-control" >
                                                    <option selected disabled>Select Any One</option>
                                                    <option :value="customer.id" v-for="(customer, key) in all_customers" :key="key">{{ customer.name }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Bill Amount</label
                                                >
                                                <input
                                                    type="text"
                                                    readonly=""
                                                    class="form-control"
                                                    placeholder="Bill Amount"
                                                    v-model="form.amount"
                                                />
                                            </div>
                                        </div>



                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Status</label
                                                >
                                                <select v-model="form.status" class="form-control">
                                                    <option selected disabled>Select Any One</option>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Unpaid">Unpaid</option>
                                                </select>
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
import { Bills } from "../../core/endpoints";
export default {
    components: {
        AppLayout,
    },
    props: {
        all_customers: {
            type: Object,
            default: {},
        },

        all_bills: {
            type: Object,
            default: {},
        },



    },

    data() {
        return {
            modal_name: "customer-modal",
            modal_title: "",
            button_name: "",
            fetchable: "fetchBills",
            filterable: "filters",
            billList: [],
            preload: false,
            meta: {},
            loading: false,
            id: null,
            form: this.initForm(),
        };
    },

    mounted() {
        this.fetchBills();
        //console.log(this.all_packages);
        this.$store.dispatch('getRoleWisePermissionList');
    },

    watch: {
        'form.customer_id'(newValue) {
            // console.log(newValue);
            this.customerWiseBillAmount(newValue);
        }
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

        async customerWiseBillAmount(customer_id){
            let { data } = await axios.get(
                `bill/customer-wise-bill/` + customer_id
            );
            //return console.log(data)
            if(data){
                this.form.amount = data[0].monthly_fee;
            }else{
                this.form.amount = null;
            }

        },

        async onSubmitForm() {
            //return console.log(this.form.name);
            try {
                this.loading = true;
                this.preload = true;
                let formId = parseInt(this.id);
                // return console.log(this.form);

                let { data } = await axios[!this.id ? "post" : "put"](
                    !this.id ? `${Bills}` : `${Bills}/${formId}`,
                    this.form
                );
                //return console.log(data)
                this.updateState(data.data, "billList", this.id);
                $("#" + this.modal_name).modal("hide");
                toastr.success(
                    `${this.id ? data.message : data.message}`,
                    "Great!"
                );
                this.fetchBills();
                this.loading = false;
                this.preload = false;
            } catch (error) {
                //return console.log(error);
                $("#" + this.modal_name).modal("hide");
                this.setFormErrors(error);
                toastr.error("Failed to create Package!", "Opps!");
                this.loading = false;
                this.preload = false;
            }
        },

        async fetchBills() {
            this.preload = true;
            let { data } = await axios.get(
                `bill/lists${this.getURLQueryString()}`
            );
            //console.log(data.data)
            this.billList = data.data;
            this.meta = data.meta;
            this.preload = false;
        },
        initForm() {
            return {
                customer_id: null,
                month: null,
                year: null,
                amount: null,
                status: null,
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

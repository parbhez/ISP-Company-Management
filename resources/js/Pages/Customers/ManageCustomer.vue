<template>
    <AppLayout title="Dashboard">
        <section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">All Customer</h5>
                        </div>
                        <div class="col-md-6 text-ri text-right" v-for="(checkPermission, key) in getRoleWisePermissionList" :key="checkPermission.id">
                            <div v-if="checkPermission.name == 'customer.create'">
                            <button
                                :data-target="'#' + modal_name"
                                data-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap"
                                @click.prevent="beforeOpen"
                            >
                                Add New Customer
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
                                'Package Name',
                                'Customer Name',
                                'Email',
                                'Phone',
                                'Address',
                                'Actions',
                            ]"
                        >
                            <tr v-for="(customer, key) in customerList" :key="key">
                                <td>
                                    {{
                                        meta.per_page *
                                            (meta.current_page - 1) +
                                        (key + 1)
                                    }}
                                </td>
                                <td>
                                    <span> {{ customer.package_name }} </span>
                                </td>

                                <td>
                                    <span> {{ customer.name }} </span>
                                </td>

                                <td>
                                    <span> {{ customer.email }} </span>
                                </td>

                                <td>
                                    <span> {{ customer.phone }} </span>
                                </td>

                                <td>
                                    <span> {{ customer.address }} </span>
                                </td>

                                <td class="align-middle">
                                    <div v-for="(checkPermission, key) in getRoleWisePermissionList" :key="checkPermission.id">
                                    <button
                                        type="button"
                                        v-if="checkPermission.name == 'customer.edit'"
                                        class="btn btn-primary btn-sm mr-2"
                                        @click.prevent="
                                            onClickHandleAction('edit', customer)
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
                            v-if="customerList.length == 0"
                            :message="
                                loading
                                    ? 'Loading...'
                                    : 'Oops..! No data available in the system.'
                            "
                        ></not-found>
                    </div>

                    <div class="p-2 mt-3">
                        <v-paginate
                            v-if="customerList.length > 0"
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
                                {{ modal_title }} Customer
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
                                                    >Customer Name</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Customer Name"
                                                    v-model="form.name"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Email</label
                                                >
                                                <input
                                                    type="email"
                                                    class="form-control"
                                                    placeholder="Customer Email"
                                                    v-model="form.email"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Phone Number</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Phone Number"
                                                    v-model="form.phone"
                                                />
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Address</label
                                                >
                                                <textarea

                                                class="form-control"
                                                v-model="form.address"
                                                placeholder="Address"
                                                ></textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Package</label
                                                >
                                                <select v-model="form.package_id" class="form-control">
                                                    <option selected disabled>Select Any One</option>
                                                    <option :value="packagedata.id" v-for="(packagedata, key) in all_packages" :key="key">{{ packagedata.name }}</option>
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
import { Customers } from "../../core/endpoints";
export default {
    components: {
        AppLayout,
    },
    props: {
        all_customers: {
            type: Object,
            default: {},
        },

        all_packages: {
            type: Object,
            default: {},
        },



    },

    data() {
        return {
            modal_name: "customer-modal",
            modal_title: "",
            button_name: "",
            fetchable: "fetchCustomers",
            filterable: "filters",
            customerList: [],
            preload: false,
            meta: {},
            loading: false,
            id: null,
            form: this.initForm(),
        };
    },

    mounted() {
        this.fetchCustomers();
        //console.log(this.all_packages);
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
                    !this.id ? `${Customers}` : `${Customers}/${formId}`,
                    this.form
                );
                //return console.log(data)
                this.updateState(data.data, "customerList", this.id);
                $("#" + this.modal_name).modal("hide");
                toastr.success(
                    `${this.id ? data.message : data.message}`,
                    "Great!"
                );
                this.fetchCustomers();
                this.loading = false;
                this.preload = false;
            } catch (error) {
                //return console.log(error);
                $("#" + this.modal_name).modal("hide");
                this.setFormErrors(error);
                toastr.error("Failed to create customer!", "Opps!");
                this.loading = false;
                this.preload = false;
            }
        },

        async fetchCustomers() {
            this.preload = true;
            let { data } = await axios.get(
                `customer/lists${this.getURLQueryString()}`
            );
            //console.log(data.data)
            this.customerList = data.data;
            this.meta = data.meta;
            this.preload = false;
        },
        initForm() {
            return {
                name: null,
                package_id: null,
                phone: null,
                email: null,
                address: null,
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

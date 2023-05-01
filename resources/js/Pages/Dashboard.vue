<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">
                <div class="row" v-if="userWiseRolePermission.includes('dashboard.view') || userWiseRolePermission.includes('dashboard.edit') ">
                    <div class="col-12 dashboard-users">
                        <div class="row">
                            <!-- Statistics Cards Starts -->
                            <div class="col-12">
                                <div class="row">
                                    <div
                                        class="col-sm-3 col-12 dashboard-users-success"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                        class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50"
                                                    >
                                                        <i
                                                            class="bx bx-briefcase-alt font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Role
                                                    </div>
                                                    <h3 class="mb-0">{{totalRole}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-sm-3 col-12 dashboard-users-success"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                        class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50"
                                                    >
                                                        <i
                                                            class="bx bx-briefcase-alt font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Permission
                                                    </div>
                                                    <h3 class="mb-0">{{totalPermission}}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-sm-3 col-12 dashboard-users-danger"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                        class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50"
                                                    >
                                                        <i
                                                            class="bx bx-user font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Users
                                                    </div>
                                                    <h3 class="mb-0">{{ totalUser }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-sm-3 col-12 dashboard-users-danger"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                        class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50"
                                                    >
                                                        <i
                                                            class="bx bx-user font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Customer
                                                    </div>
                                                    <h3 class="mb-0">{{ totalCustomer }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-sm-3 col-12 dashboard-users-danger"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                    class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50"
                                                    >
                                                        <i
                                                        class="bx bx-briefcase-alt font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Deposit Transaction
                                                    </div>
                                                    <h3 class="mb-0">{{ totalDepositTransaction }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-sm-3 col-12 dashboard-users-danger"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                    class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50"
                                                    >
                                                        <i
                                                        class="bx bx-briefcase-alt font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Withdraw Transaction
                                                    </div>
                                                    <h3 class="mb-0">{{ totalWithdrawTransaction }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-sm-3 col-12 dashboard-users-danger"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                    class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50"
                                                    >
                                                        <i
                                                        class="bx bx-briefcase-alt font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Expense
                                                    </div>
                                                    <h3 class="mb-0">{{ totalExpense }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-sm-3 col-12 dashboard-users-danger"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                    class="badge-circle badge-circle-lg badge-circle-light-success mx-auto mb-50"
                                                    >
                                                        <i
                                                        class="bx bx-briefcase-alt font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Bill Collection
                                                    </div>
                                                    <h3 class="mb-0">{{ totalBillCollection }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="col-sm-3 col-12 dashboard-users-danger"
                                    >
                                        <div class="card text-center">
                                            <div class="card-content">
                                                <div class="card-body py-1">
                                                    <div
                                                    class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto mb-50"
                                                    >
                                                        <i
                                                        class="bx bx-briefcase-alt font-medium-5"
                                                        ></i>
                                                    </div>
                                                    <div
                                                        class="text-muted line-ellipsis"
                                                    >
                                                        Total Bill Pending
                                                    </div>
                                                    <h3 class="mb-0">{{ totalBillPending }}</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Revenue Growth Chart Starts -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h2>Do not assign any permission. Please contact admin.</h2>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Dashboard Ecommerce ends -->
        </div>
    </AppLayout>
</template>

<script>
export default {
    props: {
        totalUser: {
            type: [String, Number],
            default: 0,
        },

        totalRole: {
            type: [String, Number],
            default: 0,
        },

        totalCustomer: {
            type: [String, Number],
            default: 0,
        },

        totalPermission: {
            type: [String, Number],
            default: 0,
        },
        totalDepositTransaction: {
            type: [String, Number],
            default: 0,
        },

        totalWithdrawTransaction: {
            type: [String, Number],
            default: 0,
        },

        totalExpense: {
            type: [String, Number],
            default: 0,
        },

        totalBillCollection: {
            type: [String, Number],
            default: 0,
        },

        totalBillPending: {
            type: [String, Number],
            default: 0,
        },
    },

    data(){
        return {
            userWiseRolePermission:[]
        }
    },

    mounted() {
        //console.log(this.totalUser);

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

    computed: {
        getRoleWisePermissionList(){
           return this.$store.getters.roleWisePermissionList;
        },
    },
};
</script>

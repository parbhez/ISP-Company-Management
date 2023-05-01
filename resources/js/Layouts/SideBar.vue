

<template>
    <!-- BEGIN: Main Menu-->
    <div
        class="main-menu menu-fixed menu-light menu-accordion menu-shadow"
        data-scroll-to-active="true"
    >
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <Link
                        class="navbar-brand"
                        :href="route('dashboard')"
                    >
                        <div class="brand-logo">
                            <img
                                class="logo"
                                src="../../../public/app-assets/images/logo/logo.png"
                            />
                        </div>
                        <h2 class="brand-text mb-0">ISP</h2>
                    </Link>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul
                class="navigation navigation-main"
                id="main-menu-navigation"
                data-menu="menu-navigation"
                data-icon-style=""
            >
                <li class="nav-item" :class="{ 'active': $page.component === 'Dashboard' }">
                    <Link :href="route('dashboard')"
                        ><i class="bx bx-home-alt"></i
                        ><span class="menu-title" data-i18n="Dashboard"
                            >Dashboard</span
                        >
                    </Link>
                </li>
                <li class="navigation-header"><span>User Management</span></li>

                <!-- {{ permisions }} -->
               <li class="nav-item" v-if="userWiseRolePermission.includes('role.create') || userWiseRolePermission.includes('role.view') ||userWiseRolePermission.includes('role.edit') || userWiseRolePermission.includes('role.delete') || userWiseRolePermission.includes('role.approve')" :class="{ 'active': $page.component === 'Roles/Index' }">

                <Link :href="route('roles.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Role Manage"
                            >Manage Role</span>
                </Link>

                </li>

                <li class="nav-item" v-if="userWiseRolePermission.includes('permission.create') || userWiseRolePermission.includes('permission.view') ||userWiseRolePermission.includes('permission.edit') || userWiseRolePermission.includes('permission.delete') || userWiseRolePermission.includes('permission.approve')" :class="{ 'active': $page.component === 'Permissions/ManagePermission' }">
                <Link :href="route('permissions.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Role Manage"
                            >Manage Permission</span>
                </Link>
                </li>

                <li class="nav-item" v-if="userWiseRolePermission.includes('user.create') || userWiseRolePermission.includes('user.view') ||userWiseRolePermission.includes('user.edit') || userWiseRolePermission.includes('user.delete') || userWiseRolePermission.includes('user.approve')" :class="{ 'active': $page.component === 'Users/ManageUser' }">
                <Link :href="route('users.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Role Manage"
                            >Manage User</span>
                </Link>
                </li>

                <li class="navigation-header"><span>ISP Management</span></li>

               <li class="nav-item" v-if="userWiseRolePermission.includes('package.create') || userWiseRolePermission.includes('package.view') ||userWiseRolePermission.includes('package.edit')" :class="{ 'active': $page.component === 'Packages/ManagePackage' }">
                <Link :href="route('packages.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Package Manage"
                            >Manage Package</span>
                </Link>
                </li>

                <li class="nav-item" v-if="userWiseRolePermission.includes('customer.create') || userWiseRolePermission.includes('customer.view') ||userWiseRolePermission.includes('customer.edit')" :class="{ 'active': $page.component === 'Customers/ManageCustomer' }">
                <Link :href="route('customers.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Customer Manage"
                            >Manage Customer</span>
                </Link>
                </li>

                <li class="nav-item" v-if="userWiseRolePermission.includes('bill.create') || userWiseRolePermission.includes('bill.view') ||userWiseRolePermission.includes('bill.edit')" :class="{ 'active': $page.component === 'Bills/ManageBill' }">
                <Link :href="route('bills.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Bill Manage"
                            >Manage Bill</span>
                </Link>
                </li>

                <li class="nav-item" v-if="userWiseRolePermission.includes('expense.create') || userWiseRolePermission.includes('expense.view') ||userWiseRolePermission.includes('expense.edit')" :class="{ 'active': $page.component === 'Expenses/ManageExpense' }">
                <Link :href="route('expenses.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Expenses Manage"
                            >Manage Expense</span>
                </Link>
                </li>

                <li class="navigation-header"><span>Account Management</span></li>

               <li class="nav-item" v-if="userWiseRolePermission.includes('account.create') || userWiseRolePermission.includes('account.view') ||userWiseRolePermission.includes('account.edit')" :class="{ 'active': $page.component === 'Accounts/ManageAccount' }">
                <Link :href="route('accounts.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Account Manage"
                            >Manage Account</span>
                </Link>
                </li>

                <li class="navigation-header"><span>Transactions Statement</span></li>

                <li class="nav-item" v-if="userWiseRolePermission.includes('transaction.create') || userWiseRolePermission.includes('transaction.view')" :class="{ 'active': $page.component === 'Transactions/ManageTransaction' }">
                <Link :href="route('transactions.index')"
                        ><i class="bx bx-save"></i
                        ><span class="menu-title" data-i18n="Account Manage"
                            >Manage Transactions</span>
                </Link>
                </li>

            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->
</template>


<script>

export default {

    data(){
        return {
            userWiseRolePermission:[]
        }
    },
    mounted() {
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

    methods:{

    }
}

</script>

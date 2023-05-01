<template>
    <AppLayout title="Dashboard">
        <section>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title">All Roles</h5>
                        </div>
                        <div class="col-md-6 text-ri text-right" v-for="(checkPermission, key) in getRoleWisePermissionList" :key="checkPermission.id">
                            <div v-if="checkPermission.name == 'role.create'">
                            <button
                                :data-target="'#' + modal_name"
                                data-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap"
                                @click.prevent="beforeOpen"
                            >
                                Add New Role
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
                                'Role Name',
                                'Permissions',
                                'Actions',
                            ]"
                        >
                            <tr v-for="(role, key) in roleList" :key="key">
                                <td>
                                    {{
                                        meta.per_page *
                                            (meta.current_page - 1) +
                                        (key + 1)
                                    }}
                                </td>
                                <td>
                                    <span> {{ role.name }} </span>
                                </td>

                                <td>
                                    <span v-for="(permission, key) in role.permissions" :key="key" class="badge badge-info" style="margin-bottom: 4px;margin-right: 5px;"> {{ permission.name }} </span>
                                </td>

                                <td class="align-middle">

                                    <div v-for="(checkPermission, key) in getRoleWisePermissionList" :key="checkPermission.id">
                                        <button
                                        type="button"
                                        v-if="checkPermission.name == 'role.edit'"
                                        class="btn btn-primary btn-sm mr-2"
                                        @click.prevent="
                                            onClickHandleAction('edit', role)
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
                            v-if="roleList.length == 0"
                            :message="
                                loading
                                    ? 'Loading...'
                                    : 'Oops..! No data available in the system.'
                            "
                        ></not-found>
                    </div>

                    <div class="p-2 mt-3">
                        <v-paginate
                            v-if="roleList.length > 0"
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
                                {{ modal_title }} Role
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
                                                    >Role Name</label
                                                >
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Role Name"
                                                    v-model="form.name"
                                                />
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="form-group">
                                                <label
                                                    for="first-name-vertical"
                                                    style="margin-bottom: 10px"
                                                    >Permissions</label
                                                >
                                                <br />
                                                <div class="checkbox">
                                                    <input
                                                        type="checkbox"
                                                        class="checkbox-input"
                                                        v-model="
                                                            checkPermissionAll
                                                        "
                                                        id="checkPermission"
                                                        value="1"
                                                    />
                                                    <label for="checkPermission"
                                                        >All</label
                                                    >
                                                </div>
                                                <hr />

                                                <div
                                                    class="row mb-2"
                                                    v-for="(
                                                        permissions,
                                                        groupNameKey,
                                                        i
                                                    ) in permission_groups"
                                                >
                                                    <div class="col-3">
                                                        <div>
                                                            <ul
                                                                class="list-unstyled mb-0"
                                                            >
                                                                <li
                                                                    class="mr-2 mb-1"
                                                                >
                                                                    <fieldset>
                                                                        <!-- <div class="checkbox">
                                                                            <input type="checkbox" class="checkbox-input" id="groupCheck" :value="groupNameKey">
                                                                            <label for="groupCheck">{{ groupNameKey}}</label>
                                                                        </div> -->

                                                                        <div>
                                                                            <label
                                                                                for="groupCheck"
                                                                                class="checkbox label"
                                                                                >{{
                                                                                    groupNameKey
                                                                                }}</label
                                                                            >
                                                                        </div>
                                                                    </fieldset>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <div
                                                        :class="
                                                            'col-9 role-' +
                                                            i +
                                                            '-management-checkbox'
                                                        "
                                                    >
                                                        <div class="checkbox">
                                                            <ul
                                                                class="list-unstyled mb-0"
                                                            >
                                                                <li
                                                                    class="mr-2"
                                                                    v-for="(
                                                                        permission,
                                                                        key
                                                                    ) in permissions"
                                                                    style="
                                                                        margin-bottom: 3px !important;
                                                                    "
                                                                >
                                                                    <fieldset>
                                                                        <div
                                                                            class="checkbox"
                                                                        >
                                                                            <input
                                                                                type="checkbox"

                                                                                class="checkbox-input"
                                                                                v-model="
                                                                                    form.permissions
                                                                                "
                                                                                :id="
                                                                                    'checkPermission' +
                                                                                    permission.id
                                                                                "
                                                                                :value="
                                                                                    permission.id
                                                                                "
                                                                            />
                                                                            <label
                                                                                :for="
                                                                                    'checkPermission' +
                                                                                    permission.id
                                                                                "
                                                                                >{{
                                                                                    permission.name
                                                                                }}</label
                                                                            >
                                                                        </div>
                                                                    </fieldset>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
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
import { Roles } from "../../core/endpoints";
export default {
    components: {
        AppLayout,
    },
    props: {
        roles: {
            type: Object,
            default: {},
        },

        all_permissions: {
            type: Object,
            default: {},
        },

        permission_groups: {
            type: Object,
            default: {},
        },
    },

    data() {
        return {
            // checkPermissionAll: "",
            modal_name: "role-modal",
            modal_title: "",
            button_name: "",
            fetchable: "fetchRoles",
            filterable: "filters",
            roleList: [],
            preload: false,
            meta: {},
            loading: false,
            id: null,
            form: this.initForm(),
        };
    },

    mounted() {
        this.fetchRoles();
        //console.log(this.all_permissions);
        this.$store.dispatch('getRoleWisePermissionList');
    },

    watch: {

    },

    computed: {
        getRoleWisePermissionList(){
            return this.$store.getters.roleWisePermissionList;
        },
        checkPermissionAll: {
            get: function () {
                return this.all_permissions
                    ? this.form.permissions.length == this.all_permissions.length
                    : false;
            },
            set: function (value) {
                var selectedArr = [];

                if (value) {
                    this.all_permissions.forEach(function (permission) {
                        selectedArr.push(permission.id);
                    });
                }

                this.form.permissions = selectedArr;
            },
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
                    !this.id ? `${Roles}` : `${Roles}/${formId}`,
                    this.form
                );
                //return console.log(data)
                this.updateState(data.data, "roleList", this.id);
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
                toastr.error("Failed to create Role!", "Opps!");
                this.loading = false;
                this.preload = false;
            }
        },

        async fetchRoles() {
            this.preload = true;
            let { data } = await axios.get(
                `role/lists${this.getURLQueryString()}`
            );
            //console.log(data.data)
            this.roleList = data.data;
            this.meta = data.meta;
            this.preload = false;
        },
        initForm() {
            return {
                name: null,
                permissions: [],
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

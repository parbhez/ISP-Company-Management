const formActionMixin = {
    methods: {
        _initForm(data) {
            // this.form = {};
            this.id = null;
            if (data) {
                this.id = data.id;
                for (let key in this.form) {
                    this.form[key] =
                        data[key] || data[key] !== "null" ? data[key] : "";
                }
                this.form["id"] = parseInt(this.id);
                //return console.log(this.form);
            }
        },

        setFormErrors(error) {
            this.loading = false;
            if (error.response.status === 422) {
                if (error.response.data.errors) {
                    for (const [k, v] of Object.entries(
                            error.response.data.errors
                        )) {
                        toastr.warning(v);
                    }
                }
                return;
            }
        },

        onClickHandleAction(...payload) {
            this.modal_title = "Edit";
            this.button_name = "Update";
            let [type, data] = payload;
            this.id = parseInt(data.id);
            this.form = data;
            // console.log(this.form)

            //Only for role edit
            var selectedArr = [];
            if (data.userWisePermissions) {
                data.userWisePermissions.forEach(function(permission) {
                    selectedArr.push(permission.id);
                });

                this.form.permissions = selectedArr;
            }

            //Only for User edit
            var selectedRoleId = null;
            if (data.userWiseRoles) {
                data.userWiseRoles.forEach(function(role) {
                    // console.log(role.id)
                    selectedRoleId = role.id;
                });
                this.form.roles = selectedRoleId;
            }
            // console.log(this.form)
            // console.log(this.form.permissions);
            // if Edit, then load the edit modal
            // if delete, delete the row targeted
            if (type == "edit") {
                // this.$modal.show(this.modal_name, data)
                $("#" + this.modal_name).modal("show", this.form);
            } else if (type == "delete") {
                confirm().then((isConfirm) =>
                    isConfirm ? this.destroy(data) : false
                );
            }
        },

        updateState(data, key, id, idx = null) {
            // push the newly inserted data to list (top)
            // or if updated, update data from list by key
            // if deleted, slice remove deleted data from list
            //console.log(id);
            this.loading = false;
            // this.$modal.hide(this.modal_name)
            let collections = this[key]; // get array of list which iterate into the table
            //console.log(collections);
            if (!id) {
                collections.unshift(data);
                return;
            }
            if (idx) {
                collections[idx] = data;
                return;
            }
            //collections[collections.findIndex(item => item.id == id)] = data

            let collectionItem =
                collections[collections.findIndex((item) => item.id == id)];
            // console.log(collectionItem);
            for (let key in data) {
                collectionItem[key] = data[key];
            }
        },

        pageChange({ page, limit }) {
            history.pushState(
                null,
                null,
                `?${this.buildURLQuery(
                    { limit: limit || 10, page: page || 1 },
                    true
                )}`
            );
            // fetchable will fetch/re-fetch the list data
            this[this.fetchable]();
        },

        applySearch(str) {
            history.pushState(
                null,
                null,
                `?${this.buildURLQuery({ q: str }, true)}`
            );
            // fetchable will fetch/re-fetch the list data
            this[this.fetchable]();
        },

        changeOrderBy({ order, direction }) {
            history.pushState(
                null,
                null,
                `?${this.buildURLQuery({ order, direction }, true)}`
            );
            this[this.fetchable]();
        },

        filterBy(column, event = null, value = null) {
            // return console.log(column)
            //return console.log(this[this.fetchable]())
            // column is database field name, use for filter by
            // value will be taken from event
            let key = column;

            var filter = {};
            if (value != null) {
                filter[column] = value;
            } else {
                filter[column] = event.target.value;
            }

            history.pushState(
                null,
                null,
                `?${this.buildURLQuery(filter, true)}`
            );
            this[this.fetchable]();
            //this.fetchWebManagerNewsList();
        },

        // validate(...params) {
        //     this.$validator.validateAll().then((result) => {
        //         if (result) {
        //             this.submit(...params)
        //         }
        //     })
        // },
    },
};

export default formActionMixin;
<template>
    <div id="assign-user" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Filter</label>
                            <input type="text" class="form-control" placeholder="Search by Email"
                                @keyup="getUsers" v-model="search_term" />
                        </div>
                        <table class="table table-condensed table-striped table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td>Email</td>
                                </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, key) in users" :key="key">
                                <td><input type="radio" id="user_email" name="user_email"
                                    v-model="user_email" :value="user.email" /></td>
                                <td>{{ user.email }}</td>
                            </tr>
                            </tbody>
                        </table>
                        
                        <span class="pull-right">
                            <button type="button" class="btn btn-sm" data-dismiss="modal"
                                @click="assignUserToVoucher">Assign User</button>
                           
                            <button class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['voucher'],
    data: function() {
        return {
            users: [],
            search_term: '',
            user_email: ''
        }
    },
    mounted() {
       this.getUsers();
    },
    methods: {
        getUsers: function() {
            var vue = this;
            var input = { search: this.search_term };
            axios.post('/users/list/', input).then(function (response) {
                vue.users = response.data.users.data;
            }).catch(error => {
                if(error.response.status == '401'){
                    toastr.error(error.response.data, 'Error!', {timeOut: 5000});
                }else{
                     toastr.error(JSON.stringify(error.response.data.errors), 'Error!', {timeOut: 5000});
                }
            });
        },
        assignUserToVoucher: function() {
            var vue = this;
            var input = {
                'email': this.user_email,
                'voucher_id': this.voucher.id
            };
            axios.post('/voucher/assign/user', input).then(function (response) {
                toastr.success('User Assigned'
                          , 'Success!', {timeOut: 5000});
                vue.$emit('reload');
            }).catch(error => {
                if(error.response.status == '401'){
                    toastr.error(error.response.data, 'Error!', {timeOut: 5000});
                }else{
                    toastr.error(JSON.stringify(error.response.data.errors), 'Error!', {timeOut: 5000});
                }
            });
        },
    }
}
</script>
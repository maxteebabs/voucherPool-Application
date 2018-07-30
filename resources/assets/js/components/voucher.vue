<template>
    <div class="wrapper">
        <h2>Willkommensgutscheine</h2>
        <hr />
        <div class="row">
            <div class="col-md-4 stat-block">
                <h3>{{ total_vouchers }}</h3>
                <p>Getsamte Gutschiene</p>
            </div>
            <div class="col-md-4 stat-block">
                <h3>{{ unused_vouchers }}</h3>
                <p>Unbenutzte Gutschiene</p>
            </div>
            <div class="col-md-4 stat-block">
                <h3>{{ used_vouchers }}</h3>
                <p>Benutzte Gutschiene</p>
            </div>
        </div>
        <hr />
        <div class="row action_wrapper">
            <div class="col-12">
                <button class="btn btn-primary" data-toggle="modal" data-target="#generate-voucher">
                    <i class="fa fa-plus"></i> 
                    Gutscheine hinzufugen</button>
                <button class="btn">
                    <i class="fa fa-cog"></i></button>
            </div>
        </div>
        <generate-voucher></generate-voucher>
        <assign-user :voucher="voucher" @reload="getData"></assign-user>

        <table id="example2" class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <td><input type="checkbox" id="checkbox" @click="toggleCheckboxes($event)" /></td>
                    <td>CODE</td>
                    <td><center>BENUTZT</center</td>
                    <td>EMPFANGER</td>
                    <td>VERWENDUNGSDATUM</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(voucher, index) in vouchers" :key="index"> 
                    <td><input type="checkbox" class="checkboxes" /></td>
                    <td>{{ voucher.vouchers }}
                        <span class="pull-right">
                            <button class="btn" @click="openAssignUser(voucher)">
                                <i class="fa fa-cog"></i>
                            </button>
                        </span>
                    </td>
                     <td><center>
                        <span v-if="voucher.usage == 1">
                            <i class="fa fa-check"></i>
                        </span>
                        <span v-else>
                            <i class="fa fa-times"></i>
                        </span>
                        </center>
                    </td>
                    <td><span v-if="voucher.user">{{ voucher.user.email}}</span></td>
                    <td><span v-if="voucher.usage_date">{{voucher.usage_date}}</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        data: function() {
            return {
                users: [],
                total_vouchers: 0,
                used_vouchers: 0,
                unused_vouchers: 0,
                vouchers: {},
                voucher: {}
            }
        },
        mounted() {
            this.getData();
        },
        methods: {
            getUsers: function() {
                var vue = this;
                axios.post('/users/listdd').then(function (response) {
                    vue.users = response.data.users;
                });
            },
            getData: function() {
                var vue = this;
                axios.get('/voucher/vouchers')
                .then(function (response) {
                    vue.total_vouchers = response.data.total_vouchers;
                    vue.used_vouchers = response.data.used_vouchers;
                    vue.unused_vouchers = response.data.unused_vouchers;
                    vue.vouchers = response.data.vouchers;
                });
            },
            openAssignUser:function(data) {
                this.voucher = data;
                $('#assign-user').modal('show');
            },
            toggleCheckboxes: function(event) {
                $('.checkboxes').attr('checked', event.target.checked);
            }
        }
    }
</script>
<style>
    table{
        margin: 15px 0px 25px
    }
    .wrapper {
        margin-top: 40px
    }
    .action_wrapper {
        margin-top: 20px;
        margin-bottom: 20px;
    }
</style>
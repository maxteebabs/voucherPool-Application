<template>
    <div id="generate-voucher" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Special Offer</label>
                            <select v-model="special_offer_id" required
                                class="form-control"
                                style="width:100%;" >
                                <option value="">Select</option>
                                <option v-for="(offer,index) in offers"
                                     :key="index" :value="offer.id">
                                    {{ offer.name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Percentage Discount</label>
                            <input type="text" v-model="percentage_discount" class="form-control" required />
                        </div>
                        <div class="form-group" v-if="vouchers">
                            <label>Voucher Code</label>
                            <input type="text" v-model="vouchers" class="form-control" readOnly />
                        </div>
                        <div class="form-group" v-show="vouchers">
                            <label>Expiry Date</label>
                            <input type="text" id="expiry_date" 
                                v-model="expiry_date" class="form-control datetimepicker" />
                        </div>
                        <span class="pull-right">
                            <button type="button" class="btn btn-sm" @click="generateVoucher">Generate Voucher</button>
                            <button type="button" data-dismiss="modal" 
                                class="btn btn-primary btn-sm" v-if="vouchers"
                                 @click="addVoucher">Add</button>
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
    data: function() {
        return {
            special_offer_id: '',
            percentage_discount: '',
            vouchers: null,
            offers: [],
            expiry_date: ''
        }
    },
    mounted() {
        this.getOffers();
    },
    methods: {
        getOffers: function() {
            var vue = this;
             axios.get('/special/offers/list').then(function (response) {
                vue.offers = response.data.results;
            }).catch(error => {
                if(error.response.status == '401'){
                    toastr.error(error.response.data, 'Error!', {timeOut: 5000});
                }else{
                     toastr.error(JSON.stringify(error.response.data.errors), 'Error!', {timeOut: 5000});
                }
            });
        },
        generateVoucher: function() {
            var vue = this;
            var input = {
                'special_offer_id': this.special_offer_id,
                'percentage_discount': this.percentage_discount
            };
            axios.post('/voucher/generate', input).then(function (response) {
                vue.vouchers = response.data.vouchers;
                 jQuery('.datetimepicker').datetimepicker({
                    format:'Y-m-d H:i:s',
                    datepicker:true,
                    // startDate:'+1971/05/01'
                });
            }).catch(error => {
                if(error.response.status == '401'){
                    toastr.error(error.response.data, 'Error!', {timeOut: 5000});
                }else{
                    toastr.error(JSON.stringify(error.response.data.errors), 'Error!', {timeOut: 5000});
                }
            });
        },
        addVoucher: function() {
            var vue = this;
            var input = {
                'special_offer_id': this.special_offer_id,
                'percentage_discount': this.percentage_discount,
                'vouchers': this.vouchers,
                'expiry_date': $('#expiry_date').val()
            };
            axios.post('/voucher/add', input).then(function (response) {
                toastr.success('Voucher added'
	                      , 'Success!', {timeOut: 5000});
            }).catch(error => {
                if(error.response.status == '401'){
                    toastr.error(error.response.data, 'Error!', {timeOut: 5000});
                }else{
                    toastr.error(JSON.stringify(error.response.data.errors), 'Error!', {timeOut: 5000});
                }
            });
        }
    }
}
</script>
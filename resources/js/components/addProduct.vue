<template>
    <div>
    <div class="card">
        <div class="card-header">Add New Product</div>
        <div class="card-body">
            <div class="card card-body bg-light text-center" >
                <form action="#" @submit.prevent="saveRecord">
                    <div class="form-group row">
                        <label for="product_name" class="col-sm-2 col-form-label">Product Name</label>
                        <div class="col-sm-6" >
                            <input type="text"
                                   class="form-control"
                                   id="product_name"
                                   v-model="creating.form.product_name"

                                   :class="{ ' is-invalid' : creating.errors['product_name'] }"
                            >
                            <small v-if="creating.errors['product_name']" class="form-text text-muted">
                                {{ creating.errors['product_name'][0]}}
                            </small>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="quantity_in_stock" class="col-sm-2 col-form-label">Quantity in stock</label>
                        <div class="col-sm-6" >
                            <input type="number"
                                   min="0"
                                   class="form-control"
                                   id="quantity_in_stock"
                                   v-model="creating.form.quantity_in_stock"

                                   :class="{ ' is-invalid' : creating.errors['quantity_in_stock'] }"
                            >
                            <small  v-if="creating.errors['quantity_in_stock']" class="form-text text-muted">
                                {{ creating.errors['quantity_in_stock'][0]}}
                            </small>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="price_per_item" class="col-sm-2 col-form-label">Price per item</label>
                        <div class="col-sm-6" >
                            <input type="number"
                                   min="0"
                                   class="form-control"
                                   id="price_per_item"
                                   v-model="creating.form.price_per_item"

                                   :class="{ ' is-invalid' : creating.errors['price_per_item'] }"
                            >
                            <small  v-if="creating.errors['price_per_item']" class="form-text text-muted">
                                {{ creating.errors['price_per_item'][0]}}
                            </small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            <button type="submit" class="btn btn-primary" id="create">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <view-product :products="data" :endpoint="endpoint" v-on:refresh="refresh"></view-product>
    </div>
</template>

<script>
    import queryString from 'query-string'
    import ViewProduct from './viewProduct.vue'
    export default {
        props: ['endpoint'],
        name: "addProduct",
        data(){
            return {
                data:{},
                creating:{
                    active:false,
                    form:{},
                    errors: []
                }
            }
        },
        components:{
            ViewProduct
        },
        methods:{
            getQueryParameters(){
                return queryString.stringify({
                    page:1
                })
            },
            getRecords(){
                return axios.get(`${this.endpoint}?${this.getQueryParameters()}`).then((response) => {
                    this.data = response.data
                })
            },
            saveRecord(){
                axios.post(`${this.endpoint}`, this.creating.form).then(()=>{
                    this.getRecords().then(() => {
                        this.creating.active = false
                        this.creating.form = {}
                        this.creating.errors = []
                    })
                }).catch((error) => {
                    console.log(error)
                    if(error.response.status === 422){
                        this.creating.errors = error.response.data.errors
                    }

                })
            },
            refresh(){
                this.getRecords()
            }
        },
        mounted() {
            this.getRecords()
        }
    }
</script>

<style scoped>

</style>

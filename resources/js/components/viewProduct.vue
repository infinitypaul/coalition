<template>
    <div class="card mt-4" >
        <div class="card-header" v-if="selected.length">
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> With Selected</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#" @click.prevent="destroy(selected)">Delete {{ selected.length }} record </a>
                </div>
            </div>
        </div>
        <div class="card-header" v-else>
            All Product
        </div>
        <div class="card-body">
            <div class="table-responsive" v-if="filteredRecords.length">
                <table class="table table-hover">
                    <thead>
                    <th  v-if="canSelectItems">
                        <input
                            type="checkbox"
                            @change="toggleSelectAll"
                            :checked="filteredRecords.length === selected.length"

                        />

                    </th>
                    <th>
                        <span class="sortable" @click="sortBy('product_name')">Product Name</span>
                        <span class="arrow" v-if="sort.key === 'product_name'"
                              :class="{ 'arrow--asc' : sort.order === 'asc', 'arrow--desc' : sort.order === 'desc' }"></span>
                    </th>
                    <th>
                        <span class="sortable" @click="sortBy('quantity')">Quantity</span>
                        <span class="arrow" v-if="sort.key === 'quantity'"
                              :class="{ 'arrow--asc' : sort.order === 'asc', 'arrow--desc' : sort.order === 'desc' }"></span>
                    </th>
                    <th>
                        <span class="sortable" @click="sortBy('price_per_item')">Price Per Item</span>
                        <span class="arrow" v-if="sort.key === 'price_per_item'"
                              :class="{ 'arrow--asc' : sort.order === 'asc', 'arrow--desc' : sort.order === 'desc' }"></span>
                    </th>
                    <th>Total Value</th>
                    <th>
                        <span class="sortable" @click="sortBy('date')">Date</span>
                        <span class="arrow" v-if="sort.key === 'date'"
                              :class="{ 'arrow--asc' : sort.order === 'asc', 'arrow--desc' : sort.order === 'desc' }"></span>
                    </th>
                    <th></th>
                    </thead>
                    <tbody>
                        <tr v-for="record in filteredRecords">
                            <td v-if="canSelectItems">
                                <input type="checkbox"
                                       v-model="selected"
                                       :value="record.id"

                                />

                            </td>
                            <td>{{ record.product_name}}</td>
                            <td>{{ record.quantity}}</td>
                            <td>{{ record.price}}</td>
                            <td>{{ record.total_value}}</td>
                            <td>{{ record.human_readable_date}}</td>
                            <td><a v-bind:href="'product/'+record.id+'/edit'" title="Edit">Edit</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Total Value</th>
                            <td colspan="3"></td>
                            <td>{{ products.total_sum}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "viewProduct",
        props: ['products', 'endpoint'],
        data(){
            return {
                sort:{
                    key:'product_name',
                    order:'desc'
                },
                selected:[]
            }
        },
        computed: {
            filteredRecords() {
                let data = this.products.data
                if (this.sort.key) {
                    data = _.orderBy(data, (i) => {
                        let value = i[this.sort.key]
                        if (!isNaN(parseFloat(value))) {
                            return parseFloat(value)
                        }

                        return String(i[this.sort.key]).toLowerCase()
                    }, this.sort.order)
                }
                return data
            },
            canSelectItems(){
                return this.filteredRecords.length <= 90
            }
        },
        methods:{
            sortBy(column){
                this.sort.key = column
                this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc'

            },
            toggleSelectAll(){
                if(this.selected.length > 0){
                    this.selected = []
                    return
                }
                this.selected = _.map(this.filteredRecords, 'id')
            },
            destroy(record){
                if(!window.confirm('Are You sure you want to Delete this')){
                    return
                }
                axios.delete(`${this.endpoint}/${record}`).then(()=>{
                    this.selected = []
                    this.$emit('refresh')
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .sortable {
        cursor: pointer;
    }

    .arrow{
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: .6;

        &--asc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-bottom: 4px solid #222;
        }


        &--desc {
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 4px solid #222;
        }
    }
</style>

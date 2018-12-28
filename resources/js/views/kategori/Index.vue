<template>
    <div class="animated fadeIn">

        <b-row>

            <b-col md="12">
                    <template>
                        <div>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>Kategori</v-toolbar-title>
                                <v-divider
                                        class="mx-2"
                                        inset
                                        vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-dialog v-model="dialog" max-width="500px">
                                    <v-btn slot="activator" color="primary" dark class="mb-2">Kategori</v-btn>
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container grid-list-md>
                                                <v-layout wrap>
                                                    <v-flex xs12 sm12 md12>
                                                        <v-text-field v-model="editedItem.kategori" label="Kategori"></v-text-field>
                                                    </v-flex>
                                                    <!--<v-flex xs12 sm6 md4>-->
                                                        <!--<v-text-field v-model="editedItem.calories" label="Calories"></v-text-field>-->
                                                    <!--</v-flex>-->
                                                    <!--<v-flex xs12 sm6 md4>-->
                                                        <!--<v-text-field v-model="editedItem.fat" label="Fat (g)"></v-text-field>-->
                                                    <!--</v-flex>-->
                                                    <!--<v-flex xs12 sm6 md4>-->
                                                        <!--<v-text-field v-model="editedItem.carbs" label="Carbs (g)"></v-text-field>-->
                                                    <!--</v-flex>-->
                                                    <!--<v-flex xs12 sm6 md4>-->
                                                        <!--<v-text-field v-model="editedItem.protein" label="Protein (g)"></v-text-field>-->
                                                    <!--</v-flex>-->
                                                </v-layout>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" flat @click="close">Cancel</v-btn>
                                            <v-btn v-show="!edit" color="blue darken-1" flat @click="save">Save</v-btn>
                                            <v-btn v-show="edit" color="blue darken-1" flat @click="update">Update</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-toolbar>
                            <v-data-table
                                    :headers="headers"
                                    :items="desserts"
                                    class="elevation-1"
                            >
                                <template slot="items" slot-scope="props">
                                    <!--<td>{{ props.item.name }}</td>-->
                                    <td class="text-xs-left">{{ props.item.kategori }}</td>
                                    <!--<td class="text-xs-right">{{ props.item.fat }}</td>-->
                                    <!--<td class="text-xs-right">{{ props.item.carbs }}</td>-->
                                    <!--<td class="text-xs-right">{{ props.item.protein }}</td>-->
                                    <td class="text-left layout px-0">
                                        <v-icon
                                                small
                                                class="mr-2"
                                                @click="editItem(props.item,props.item.id)"
                                        >
                                            edit
                                        </v-icon>
                                        <v-icon
                                                small
                                                @click="deleteItem(props.item,props.item.id)"
                                        >
                                            delete
                                        </v-icon>
                                    </td>
                                </template>
                                <template slot="no-data">
                                    <v-btn color="primary" @click="initialize">Reset</v-btn>
                                </template>
                            </v-data-table>
                        </div>
                    </template>
                <!--</b-card>-->
            </b-col>
        </b-row>
    </div>
</template>

<script>

    let dataTes = "Wisnu";
    let results = [];
    let parse = null;
    const baseUrl = 'http://localhost/laravel/lara_vue/public/index.php/api';
    let fetchDataKategori = ()=>{
        axios.get(`${baseUrl}/kategori`)
            .then((res)=>{
                res.data.results.forEach((value,index)=>{
                    let obj = {
                      id:value.id,
                      kategori:value.kategori,
                    };
                    results.push(obj);
                });
            })
            .catch((err)=>{
                console.log(err);
            })
    }
    import axios from 'axios';
    export default {
        beforeCreate:()=>{
            fetchDataKategori();

        },
        mounted:()=>{

        },
        name: 'tables',
        data: () => {
            return {
                edit:false,
                kategori:results,
                test:dataTes,
                dialog: false,
                headers: [
                    { text: 'Kategori', value: 'kategori' },
                    {
                        text: 'Actions',
                        align: 'left',
                        sortable: false,
                        value: 'Actions'
                    },
                ],
                desserts: [],
                editedIndex: -1,
                editedItem: {
                    name: '',
                    calories: 0,
                    fat: 0,
                    carbs: 0,
                    protein: 0,
                    kategori:'',
                    id:0
                },
                defaultItem: {
                    name: '',
                    calories: 0,
                    fat: 0,
                    carbs: 0,
                    protein: 0,
                    kategori:'',
                    id:0
                }
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Kategori Baru' : 'Edit Kategori'
            }
        },

        watch: {
            dialog (val) {
                val || this.close()
            }
        },

        created () {
            this.initialize()
        },

        methods: {
            initialize () {
                /*
                this.desserts = [
                    {
                        name: 'Frozen Yogurt',
                        calories: 159,
                        fat: 6.0,
                        carbs: 24,
                        protein: 4.0
                    },
                    {
                        name: 'Ice cream sandwich',
                        calories: 237,
                        fat: 9.0,
                        carbs: 37,
                        protein: 4.3
                    },
                    {
                        name: 'Eclair',
                        calories: 262,
                        fat: 16.0,
                        carbs: 23,
                        protein: 6.0
                    },
                    {
                        name: 'Cupcake',
                        calories: 305,
                        fat: 3.7,
                        carbs: 67,
                        protein: 4.3
                    },
                    {
                        name: 'Gingerbread',
                        calories: 356,
                        fat: 16.0,
                        carbs: 49,
                        protein: 3.9
                    },
                    {
                        name: 'Jelly bean',
                        calories: 375,
                        fat: 0.0,
                        carbs: 94,
                        protein: 0.0
                    },
                    {
                        name: 'Lollipop',
                        calories: 392,
                        fat: 0.2,
                        carbs: 98,
                        protein: 0
                    },
                    {
                        name: 'Honeycomb',
                        calories: 408,
                        fat: 3.2,
                        carbs: 87,
                        protein: 6.5
                    },
                    {
                        name: 'Donut',
                        calories: 452,
                        fat: 25.0,
                        carbs: 51,
                        protein: 4.9
                    },
                    {
                        name: 'KitKat',
                        calories: 518,
                        fat: 26.0,
                        carbs: 65,
                        protein: 7
                    }
                ]
                */

                this.desserts = results;

            },

            editItem (item,id) {
                this.edit = true;
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem.id = id;
                this.editedItem = Object.assign({}, item)
                this.dialog = true
            },

            deleteItem (item,id) {
                const index = this.desserts.indexOf(item)
                confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1) && axios.delete(`${baseUrl}/kategori/${id}`)
                    .then((response)=>{
                        console.log(response);

                    })
                    .catch((errors)=>{
                        console.log(errors);
                    })
            },

            close () {
                this.dialog = false
                setTimeout(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                }, 300)
            },

            save () {
                if (this.editedIndex > -1) {
                    Object.assign(this.desserts[this.editedIndex], this.editedItem)
                } else {
                    console.log(this.editedItem.kategori);

                    axios.post(`${baseUrl}/kategori`,{
                        kategori:this.editedItem.kategori
                    })
                        .then((res)=>{
                            console.log(res);
                        })
                        .then((err)=>{
                            console.log(err);
                        });

                    this.desserts.push(this.editedItem)
                }
                this.close()
            },

            update () {
                if (this.editedIndex > -1) {
                    axios.put(`${baseUrl}/kategori/${this.editedItem.id}`,{
                        kategori:this.editedItem.kategori
                    })
                        .then((res)=>{
                            console.log(res);
                        })
                        .then((err)=>{
                            console.log(err);
                        });
                    Object.assign(this.desserts[this.editedIndex], this.editedItem)
                } else {
                    console.log(this.editedItem.kategori);
                    /*

                     */



                    this.desserts.push(this.editedItem)
                }


                this.close()
            }
        }
    }
</script>
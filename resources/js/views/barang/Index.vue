<template>
    <div class="animated fadeIn">

        <b-row>

            <b-col md="12">
                    <template>
                        <div>
                            <v-toolbar flat color="white">
                                <v-toolbar-title >Barang</v-toolbar-title>
                                <v-divider
                                        class="mx-2"
                                        inset
                                        vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-dialog v-model="dialog" max-width="500px">
                                    <v-btn slot="activator" @click="newBarang()" color="primary" dark class="mb-2">Barang</v-btn>
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-container grid-list-md>
                                                <v-layout wrap>
                                                    <v-flex xs12 sm12 md12>
                                                        <v-text-field v-model="editedItem.nama_barang" label="Barang"></v-text-field>
                                                    </v-flex>
                                                    <!-- <v-flex xs12 sm12 md12>
                                                        <v-text-field v-model="selected" label="Kategori"></v-text-field>
                                                    </v-flex> -->
                                                    <v-flex xs12 sm12 d-flex>                                                         
                                                       <div>
                                                            <b-form-select v-model="editedItem.kategori_id" :options="options" class="mb-3" >
                                                                <option value="0">--Pilih Kategori--</option>
                                                            </b-form-select>
                                                            <div>Selected: <strong>{{ editedItem.kategori_id }}</strong></div>
                                                        </div>
                                                    </v-flex>
                                                    <v-flex xs12 sm12 md12>
                                                        <v-text-field v-model="editedItem.harga" label="Harga"></v-text-field>
                                                    </v-flex>
                                                    <v-flex xs12 sm12 md12>
                                                        <v-text-field v-model="editedItem.stok" label="Stok"></v-text-field>
                                                    </v-flex>
                                                    <!-- <v-flex xs12 sm12 md12>
                                                        <v-text-field v-model="r" label="Stok"></v-text-field>
                                                    </v-flex> -->
                                                     <v-flex
                                                            v-show="edit"
                                                        >
                                                        <v-card flat tile class="d-flex">
                                                            <v-img
                                                            width="100"
                                                            :src="`${image}`"
                                                            :lazy-src="`${image}`"
                                                            aspect-ratio="1"
                                                            class="grey lighten-2"
                                                            >
                                                            <v-layout
                                                                slot="placeholder"
                                                                fill-height
                                                                align-center
                                                                justify-center
                                                                ma-0
                                                            >
                                                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                                            </v-layout>
                                                            </v-img>
                                                        </v-card>
                                                        </v-flex>
                                                    
                                                    
                                                    <v-flex xs12 sm12 md12>
                                                        <b-form-file id="file" ref="file"  v-on:change="handleFileUpload()" placeholder="Choose a file..."></b-form-file>
                                                        <!-- <div class="mt-3">Selected file: {{defaultItem.file && defaultItem.file.name}}</div> -->
                                                     </v-flex>
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
                                    <td class="text-xs-left">{{ props.item.nama_barang }}</td>
                                    <td class="text-xs-left">{{ props.item.kategori }}</td>
                                    <td class="text-xs-left">{{ props.item.hargaRupiah }}</td>
                                    <td class="text-xs-left">{{ props.item.stok }}</td>
                                    <td class="text-xs-left">{{ props.item.status }}</td>
                                    <!--<td class="text-xs-right">{{ props.item.fat }}</td>-->
                                    <!--<td class="text-xs-right">{{ props.item.carbs }}</td>-->
                                    <!--<td class="text-xs-right">{{ props.item.protein }}</td>-->
                                    <td class="text-left layout px-0">
                                        <v-icon
                                                small
                                                class="mr-2"
                                                @click="editItem(props.item,props.item.id,props.item.gambar)"
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
    let resultsKategori = [];
    let parse = null;
    const baseUrl = 'http://localhost/laravel/lara_vue/public/index.php/api';
    let rupiah = function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    let fetchDataKategori = ()=>{
        axios.get(`${baseUrl}/barang`)
            .then((res)=>{               

                res.data.results.forEach((value,index)=>{

                    let obj = {
                      id:value.id,
                      kategori:value.kategori.kategori,
                      nama_barang:value.nama_barang,
                      gambar:`${baseUrl}/barang/img/${value.gambar}`,
                      kategori_id:value.kategori_id,
                      status:value.status,
                      stok:value.stok,
                      harga:value.harga,
                      hargaRupiah: rupiah(value.harga.toString(),"00")
                    };
                    results.push(obj);

                });
            })
            .catch((err)=>{
                console.log(err);
            })
    }

    let getKategori = ()=>{
        axios.get(`${baseUrl}/kategori`)
            .then((res)=>{
                

                res.data.results.forEach((value,index)=>{

                    let objKategori = {
                      value:value.id,
                      text:value.kategori,
                    };
                    resultsKategori.push(objKategori);

                

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
            getKategori();

        },
        mounted:()=>{
            
        },
        name: 'tables',
        data: () => {
            return {
                file:'',
                selected: 0,
                options: resultsKategori,
                image:false,
                baseUrl:baseUrl,
                edit:false,
                kategori:results,
                test:dataTes,
                dialog: false,
                headers: [
                    { text: 'Nama Barang', value: 'nama_barang' },
                    { text: 'Kategori', value: 'kategori' },
                    { text: 'Harga', value: 'harga' },
                    { text: 'Stok', value: 'stok' },
                    { text: 'Status', value: 'status' },
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
                    nama_barang:'',
                    kategori:'',
                    kategori_id:0,
                    harga:'',
                    status:'',
                    stok:'',
                    id:'',
                    gambar:'',
                   
                   
                },
                defaultItem: {                    
                    nama_barang:'',
                    kategori:'',
                    kategori_id:0,
                    harga:'',
                    status:'',
                    stok:'',
                    id:'',
                    gambar:'',
                    
                }
            }
        },
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'Barang Baru' : 'Edit Barang'
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
            handleFileUpload(){
                this.file = this.$refs.file.$refs.input.files[0];
                // console.log();
            },
            initialize () {
               
                this.desserts = results;

            },
            newBarang(){
                this.edit = false;
                console.log(this.edit);
            },
            editItem (item,id,img) {
                
                axios.get(`${img}`)
                    .then((res)=>{
                        console.log(res.data);
                        this.image = res.data;
                    })
                    .catch((err)=>{
                        console.log(err);
                    });
                   
                this.edit = true;
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem.id = id;               
                               
                this.editedItem = Object.assign({}, item)
                               
                this.dialog = true
                
            },

            deleteItem (item,id) {
                const index = this.desserts.indexOf(item)
                confirm('Are you sure you want to delete this item?') && this.desserts.splice(index, 1) && axios.delete(`${baseUrl}/barang/${id}`)
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
                    let formData = new FormData();
                    formData.append('file', this.file);
                    formData.append('nama_barang',this.editedItem.nama_barang);
                    formData.append('kategori_id',this.editedItem.kategori_id);
                    formData.append('harga',this.editedItem.harga);
                    formData.append('stok',this.editedItem.stok);
                    formData.append('status','on');

                    
                    axios.post(`${baseUrl}/barang`,formData,{
                        headers:{
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                        .then((res)=>{
                            console.log(res);
                            fetchDataKategori()
                        })
                        .then((err)=>{
                            console.log(err);
                        });
                        

                    //this.desserts.push(this.editedItem)
                }
                this.close()
            },

            update () {
                if (this.editedIndex > -1) {
                    console.log("Barang di update");
                    // this.desserts = [];
                             fetchDataKategori()
                    
                    axios.put(`${baseUrl}/kategori/${this.editedItem.id}`,{
                        kategori:this.editedItem.kategori
                    })
                        .then((res)=>{
                            // this.desserts = [];
                             fetchDataKategori()
                        })
                        .then((err)=>{
                            console.log(err);
                        });
                    //Object.assign(this.desserts[this.editedIndex], this.editedItem)
                    
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
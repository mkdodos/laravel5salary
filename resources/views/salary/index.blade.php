@extends('app')

@section('content')
<div class="container" id="app">
    <v-data-table :headers="headers" :items="desserts" :items-per-page="5" class="elevation-1"></v-data-table>
    <!-- <v-simple-table>
        <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Calories
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in desserts" :key="item.name">
                    <td>${ item.name }</td>
                    <td>${ item.calories }</td>
                </tr>
            </tbody>
        </template>
    </v-simple-table> -->
</div>
@endsection

@section('footer')
<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        delimiters: ['${', '}'],
        data() {
            return {
                headers: [{
                        text: '甜點',
                        align: 'start',
                        sortable: false,
                        value: 'name',
                    },
                    {
                        text: '卡路里',
                        value: 'calories'
                    },                    
                ],
                desserts: [{
                        name: 'Frozen Yogurt',
                        calories: 159,
                    },
                    {
                        name: 'Ice cream sandwich',
                        calories: 237,
                    },
                    {
                        name: 'Eclair',
                        calories: 262,
                    },
                    {
                        name: 'Cupcake',
                        calories: 305,
                    },
                    {
                        name: 'Gingerbread',
                        calories: 356,
                    },
                    {
                        name: 'Jelly bean',
                        calories: 375,
                    },
                    {
                        name: 'Lollipop',
                        calories: 392,
                    },
                    {
                        name: 'Honeycomb',
                        calories: 408,
                    },
                    {
                        name: 'Donut',
                        calories: 452,
                    },
                    {
                        name: 'KitKat',
                        calories: 518,
                    },
                ],
            }
        },
    })
</script>
@endsection
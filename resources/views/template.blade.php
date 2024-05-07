<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

<div id="app" class="p-3">
    <div class="btn btn-primary mb-2" @click="add_rule">
        Add rule
    </div>
    <div v-for="(rule, i) in rules" class="mb-2">
        <input class="form-control-sm mr-2" min="1" type="number" v-model="rule.count">
        <select class="form-control-sm mr-2" v-model="rule.type">
            <option value="profile">
                profile
            </option>
            <option value="advertisement">
                advertisement
            </option>
            <option value="roulette">
                roulette
            </option>
        </select>
        <span style="cursor:pointer;" @click="delete_rule(i)">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path>
                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path>
            </svg>
        </span>
    </div>

    <ul class="list-group">
        <template v-for="rule in rules">
            <li v-for="i in rule.count" :class="{'list-group-item': true, 'list-group-item-warning': rule.type == 'advertisement', 'list-group-item-success': rule.type == 'roulette',}">
                @{{ rule.type }}
            </li>
        </template>
    </ul>
</div>

<script>
const { createApp } = Vue

createApp({
    data() {
        return {
            rules: [],       
        }
    },
    methods: {
        add_rule() {
            this.rules.push({
                type: 'profile',
                count: 1,
            })
        },
        delete_rule(i) {
            this.rules = this.rules.filter((rule, n) => n != i)
        },
    },
}).mount('#app')
</script>
</body>
</html>
<template>
    <div class="card shadow" :class="{'keep-color-white':(keepColor==-1), 'keep-color-red':(keepColor==-2), 
                                            'keep-color-orange':(keepColor==-3), 'keep-color-yellow':(keepColor==-4),
                                            'keep-color-green':(keepColor==-5), 'keep-color-lightblue':(keepColor==-6),
                                            'keep-color-blue':(keepColor==-7), 'keep-color-purpur':(keepColor==-8)}">
        <div class="card-header modal-header text-right p-2">
            <h4 class="card-title modal-title text-left" style="word-break: break-all;">{{keep[0][1]}}</h4>
            <div class="btn-group" role="group">
                <button :id="'btnGroup'+keepkey" type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                <div class="dropdown-menu" :aria-labelledby="'btnGroup'+keepkey">
                    <button type="button" class="dropdown-item"  @click="redact(keepkey)">Редактировать</button>
                    <button type="button" class="dropdown-item"  @click="copy(keepkey)">Создать копию</button>
                </div>
              </div>
        </div>
        <div v-for="(text, index) in keep" v-if="index!=0" :kep="index" :class="{'card-body': (text[0]=='paragraph'),
                'list-group list-group-flush': (text[0]=='tableItem')}">
            <pre style="background-color: transparent;"><p style="background-color: transparent;" class="lead" :class="{'card-text': (text[0]=='paragraph'),
                    'list-group-item py-0': (text[0]=='tableItem')}">{{(text[0]=='tableItem')?
                        ((text[1].length > 3)?
                            ((text[1].substring(0, 3) == "&t$")?("✓ " + text[1].substring(3) + ""):
                                ((text[1].substring(0, 3) == "&f$")?("– " + text[1].substring(3)):("• " + text[1])))
                            :("• " + text[1]))
                        :text[1]}}</p></pre>
        </div>
    </div>
</template>
<script>
export default {
    name: 'keep-card',
    props: ['keep', 'keepkey', 'keepparams'],
    computed: {
        keepColor: function() {
            return JSON.parse(this.keepparams)['color_keep'];
        }
    },
    methods: {
        redact: function(keepKey) {
            this.$emit('redact', keepKey);
        }, 
        copy: function(keepKey) {
            this.$emit('copy', keepKey);
        }
    }
}
</script>
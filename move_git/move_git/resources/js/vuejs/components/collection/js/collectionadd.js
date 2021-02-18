/**
 * Created by macintosh on 14/3/20.
 */
import { mapGetters } from "vuex";

import ExplanationItem from '../template/ExplanationItem.vue';

export default {
    components: {ExplanationItem},
    name: "CollectionAdd",
    props: {lastId: Number},
    data: function () {
        return {
            posList: window.metadata.posList,
            collection: {
                value: '',
                pos: '',
                explanations: [
                    {id: 0, meanings: '', example: ''}
                ]
            }
        }
    },
    mounted()
    {
        //this.posList = window.metadata.posList;
    }
    ,
    computed: {}
    ,
    methods: {
        addExplanation()
        {
            this.collection.explanations.push(this.getExplanationModel());
        },
        removeExplanation(id)
        {
            if (this.collection.explanations[id] !== undefined) {
                this.collection.explanations.splice(id, 1);
                var i = 0;
                this.collection.explanations.forEach(function (value) {
                    value.id = i;
                    i++;
                });
            }

        },
        getExplanationModel()
        {
            var lastId = this.collection.explanations.length;
            return {id: lastId, meanings: '', example: ''};
        },
        getCollectionModel(){
            return {
                value: '',
                pos: '',
                explanations: [
                    {id: 0, meanings: '', example: ''}
                ]
            }
        },
        saveCollection(){
            var payload = {
                collection: this.collection
            };
            this.$store.dispatch("CREATE_COLLECTION", payload);
        },
        resetCollection(){
            this.collection = this.getCollectionModel();
        }
    }
}
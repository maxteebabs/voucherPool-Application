<template>
	<ul class="pagination pagination-lg">
		<li v-if="pagination.current_page > 1">
			<a href="javascript:void(0);" aria-label="Previous"
			 v-on:click.prevent="changePage(pagination.current_page - 1)">
			 <span aria-hidden="true">«</span></a>
		</li>
		<li v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}">
			<a href="javascript:void(0)" v-on:click.prevent="changePage(page)">{{ page }}</a>
		</li>
		<li v-if="pagination.current_page < pagination.last_page ">
			<a href="javascript:void(0);" aria-label="next"
				v-on:click.prevent="changePage(pagination.current_page + 1)">
				<span aria-hidden="true">»</span>
			</a>
		</li>
	</ul>
</template>

<script type="text/javascript">
	export default {
		props: {
			pagination: {
//				type: Array,
				required: true
			},
			offset: {
				type:Number,
				default: 4
			}
		},
		computed: {
			pagesNumber: function() {
				let from = this.pagination.current_page - this.offset;
				if(from < 1) {
					from = 1;
				}
				let to = from + (this.offset * 2);
				if(to > this.pagination.last_page) {
					to = this.pagination.last_page;
				}
				let collection = [];
				for (let page = from; page < to; page++) {
					collection.push(page);
				}
				return collection;
			}
		},
		methods: {
			changePage: function(page) {
				this.pagination.current_page = page;
				this.$emit('paginate');
			}
		}
	}
</script>
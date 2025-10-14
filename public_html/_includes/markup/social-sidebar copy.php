<section>
	<h3 class="section-title-lined">Social</h3>
	<!-- TWITTER FEED -->
	<!--<script src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script>
	new TWTR.Widget({
	  version: 2,
	  type: 'search',
	  search: 'Clark County School District',
	  interval: 30000,
	  title: 'Clark County School District',
	  subject: 'CCSD Buzz',
	  width: 'auto',
	  height: 300,
	  theme: {
	    shell: {
	      background: '#dddddd',
	      color: '#444444'
	    },
	    tweets: {
	      background: '#ffffff',
	      color: '#444444',
	      links: '#5588bb'
	    }
	  },
	  features: {
	    scrollbar: true,
	    loop: true,
	    live: true,
	    behavior: 'default'
	  }
	}).render().start();
	</script>-->
	
	<script src="http://widgets.twimg.com/j/2/widget.js"></script>
	<script>
	new TWTR.Widget({
	  version: 2,
	  type: 'profile',
	  rpp: 4,
	  interval: 30000,
	  width: 260,
	  height: 300,
	  theme: {
	    shell: {
	      background: '#dddddd',
	      color: '#888888'
	    },
	    tweets: {
	      background: '#ffffff',
	      color: '#444444',
	      links: '#5588bb'
	    }
	  },
	  features: {
	    scrollbar: false,
	    loop: false,
	    live: true,
	    behavior: 'default'
	  }
	}).render().setUser('@clarkcountysch').start();
	</script>
	
	<!-- FACEBOOK RECOMMENDATIONS -->
	<div class="fb-recommendations" data-site="www.ccsd.net" data-width="260" data-height="300" data-header="false" data-border-color="#ffffff"></div>
	
	<!-- Place this tag where you want the badge to render -->
	<!--<div class="google-social">
		<div class="g-plus" data-href="https://plus.google.com/117608427266758629271" data-size="badge"></div>
	</div>-->
	
</section>
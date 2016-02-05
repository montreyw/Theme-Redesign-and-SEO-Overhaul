function(a) {
	a(document).on("mouseover", ".genrebar ul li.maingenre", function() {
		$this = a(this), "none" == a(".subgenres", $this).css("display") && a(".subgenres", $this).css({
			display: "block",
			opacity: 0
		}), a(".subgenres", $this).stop().animate({
			opacity: 1
		}), a("a:first", $this).addClass("active"), a('a.maingenre:not(".active")').stop().animate({
			opacity: 1
		})
	}).on("mouseout", ".genrebar ul li.maingenre", function() {
		$this = a(this), a(".subgenres", $this).stop().animate({
			opacity: 0
		}, 500, function() {
			a(this).css("display", "none")
		}), a('a.maingenre:not(".active")').stop().animate({
			opacity: 1
		}), a("a:first", $this).removeClass("active")
	}), Earmilk.genrebar = {}, Earmilk.genrebar.reset = function() {
		$this = a(".genrebar ul li.maingenre.default"), a(".subgenres", $this).stop().animate({
			opacity: 1
		})
	}
}(jQuery),
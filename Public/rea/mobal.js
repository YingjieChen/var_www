$(function () {
	var Modal = React.createClass({
		displayName: "Modal",

		closebox: function () {
			this.isshow = false;
			this.forceUpdate();
		},
		componentDidUpdate: function () {
			var heightboxofmodal = $(".boxofmodal").height();
			var heightboxofdocumeng = $(window).height();
			var a = heightboxofdocumeng - heightboxofmodal;
			$(".boxofmodal").css({ top: a / 2 });
		},
		setFirstForm: function () {
			this.formstatus = 0;
			this.forceUpdate();
		},
		setLoginForm: function () {
			this.formstatus = 1;
			this.forceUpdate();
		},
		setRegisterForm: function () {
			this.formstatus = 2;
			this.forceUpdate();
		},
		getInitialState: function () {
			this.isshow = false;
			return {};
		},
		render: function () {
			var Loginform = "";
			switch (this.formstatus) {
				case 1:
					Loginform = React.createElement(
						"div",
						null,
						React.createElement(
							"div",
							{ className: "title" },
							"Login!"
						),
						React.createElement(
							"div",
							{ className: "fb-button" },
							React.createElement(
								"div",
								{ className: "image" },
								React.createElement("img", { src: "//main.cdn.wish.com/bc4736c509b1/img/login_modal/facebook.png?v=13" })
							),
							React.createElement(
								"span",
								{ className: "text" },
								"Login with Facebook"
							)
						),
						React.createElement(
							"div",
							{ className: "google-button" },
							React.createElement(
								"div",
								{ className: "image" },
								React.createElement("img", { src: "//main.cdn.wish.com/bc4736c509b1/img/login_modal/googleplus.png?v=13" })
							),
							React.createElement(
								"span",
								{ className: "text" },
								"Login up with Google"
							)
						),
						React.createElement(
							"div",
							{ className: "or" },
							React.createElement("hr", null),
							"or"
						),
						React.createElement(
							"form",
							{ method: "post", action: "/account/login", id: "customer_login", "accept-charset": "UTF-8" },
							React.createElement(
								"div",
								{ className: "email" },
								"email : ",
								React.createElement("input", { type: "email", name: "customer[email]", required: true })
							),
							React.createElement(
								"div",
								{ className: "password" },
								"pass: ",
								React.createElement("input", { type: "password", name: "customer[password]", required: true })
							),
							React.createElement("input", { className: "submit", type: "submit", defaultValue: "submit" })
						)
					);
					break;
				case 2:
					Loginform = React.createElement(
						"div",
						null,
						React.createElement(
							"div",
							{ className: "title", style: { margin: 0 } },
							"Register!"
						),
						React.createElement(
							"form",
							{ method: "post", action: "/account/login", id: "customer_login", "accept-charset": "UTF-8" },
							React.createElement(
								"div",
								null,
								"FIRST NAME    :    ",
								React.createElement("input", { type: "email", name: "customer[first_name]", required: true })
							),
							React.createElement(
								"div",
								null,
								"LAST NAME :    ",
								React.createElement("input", { type: "password", name: "customer[last_name]", required: true })
							),
							React.createElement(
								"div",
								null,
								"EMAIL        :       ",
								React.createElement("input", { type: "password", name: "customer[email]", required: true })
							),
							React.createElement(
								"div",
								null,
								"PASSWORD        :       ",
								React.createElement("input", { type: "password", name: "customer[password]", required: true })
							),
							React.createElement("input", { className: "submit", type: "submit", defaultValue: "submit" })
						)
					);
					break;
				default:
					Loginform = React.createElement(
						"div",
						null,
						React.createElement(
							"div",
							{ className: "title" },
							"Sign up to browse products!"
						),
						React.createElement(
							"div",
							{ className: "fb-button" },
							React.createElement(
								"div",
								{ className: "image" },
								React.createElement("img", { src: "//main.cdn.wish.com/bc4736c509b1/img/login_modal/facebook.png?v=13" })
							),
							React.createElement(
								"span",
								{ className: "text" },
								"Sign up with Facebook"
							)
						),
						React.createElement(
							"div",
							{ className: "google-button" },
							React.createElement(
								"div",
								{ className: "image" },
								React.createElement("img", { src: "//main.cdn.wish.com/bc4736c509b1/img/login_modal/googleplus.png?v=13" })
							),
							React.createElement(
								"span",
								{ className: "text" },
								"Sign up with Google"
							)
						),
						React.createElement(
							"div",
							{ className: "signup-email", onClick: this.setRegisterForm },
							"Sign up with Email"
						),
						React.createElement(
							"div",
							{ className: "or" },
							React.createElement("hr", null),
							"or"
						),
						React.createElement(
							"div",
							{ className: "login-button", onClick: this.setLoginForm },
							"Login"
						)
					);
					break;
			}

			var returnhtml = this.isshow ? React.createElement(
				"div",
				{ className: "modalboxcontainer", style: { width: "100%", height: "100%", "position": "fixed", left: 0, top: 0, right: 0, bottom: 0 } },
				React.createElement("div", { className: "modalbox", style: { width: "100%", height: "100%", opacity: 0.8, "z-index": 100000, "position": "fixed", left: 0, top: 0, background: "#000" } }),
				React.createElement(
					"div",
					{ className: "boxofmodal" },
					React.createElement(
						"div",
						{ className: "formimage" },
						React.createElement("img", { src: "//cdn.shopify.com/s/files/1/0964/9808/products/GP1810_2_1024x1024.jpg?v=1481593659" })
					),
					React.createElement(
						"div",
						{ className: "closebutton", onClick: this.closebox },
						" X "
					),
					React.createElement(
						"div",
						{ className: "loginform" },
						React.createElement(
							"div",
							{ className: "back", onClick: this.setFirstForm },
							React.createElement("img", { src: "//main.cdn.wish.com/bc4736c509b1/img/login_modal/back.png?v=13" })
						),
						Loginform
					)
				)
			) : React.createElement("div", null);
			return returnhtml;
		}
	});
	var ModalNode = ReactDOM.render(React.createElement(Modal, null), document.getElementById("modalbox"));
	$("#customer_login_link").click(function () {
		ModalNode.isshow = true;
		ModalNode.forceUpdate();
	});
});

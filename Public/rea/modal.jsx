$(function(){
	var Modal = React.createClass({
		closebox:function()
		{
			this.isshow			=	false;
			this.forceUpdate();	
		},
		componentDidUpdate:function()
		{
			var heightboxofmodal 		= 	$(".boxofmodal").height();
			var heightboxofdocumeng  	= 	$(window).height();
			var a =heightboxofdocumeng-heightboxofmodal;
			$(".boxofmodal").css({top:a/2});
		},
		setFirstForm:function()
		{
			this.formstatus			=0;
			this.forceUpdate();
		},
		setLoginForm:function()
		{
			this.formstatus			=1;
			this.forceUpdate();
		},
		setRegisterForm:function()
		{
			this.formstatus                 =2;
                        this.forceUpdate();
		},
		getInitialState:function()
		{
			this.isshow			=	false;
			return {};
		},
		render:function()
		{
			var Loginform			=	"";
			switch(this.formstatus)
			{
				case(1):
					Loginform	=	(
						<div>
                                                        <div className="title">Login!</div>
                                                        <div className="fb-button">
                                                                <div className="image">
                                                                        <img src="//main.cdn.wish.com/bc4736c509b1/img/login_modal/facebook.png?v=13"/>
                                                                </div>
                                                                <span className="text">Login with Facebook</span>
                                                        </div>
                                                        <div className="google-button">
                                                                <div className="image">
                                                                        <img src="//main.cdn.wish.com/bc4736c509b1/img/login_modal/googleplus.png?v=13"/>
                                                                </div>
                                                                <span className="text">Login up with Google</span>
                                                        </div>
                                                        <div className="or"><hr/>or</div>
                                                        <form method="post" action="/account/login" id="customer_login" accept-charset="UTF-8">
								<div className="email">
									email	:	<input type="email" name="customer[email]" required/>
								</div>
								<div className="password">
									pass:	<input type="password" name="customer[password]" required/>
								</div>
								<input className="submit" type="submit" defaultValue="submit"/>
							</form>
                                                </div>
					);	
				break;
				case(2):
					Loginform	=	(
						<div>
                                                        <div className="title" style={{margin:0}}>Register!</div>
                                                        <form method="post" action="/account/login" id="customer_login" accept-charset="UTF-8">
                                                                <div>
                                                                       	FIRST NAME   	:   	<input type="email" name="customer[first_name]" required/>
                                                                </div>
                                                                <div>
                                                                        LAST NAME	:   	<input type="password" name="customer[last_name]" required/>
                                                                </div>
								<div>
                                                                        EMAIL       	:       <input type="password" name="customer[email]" required/>
                                                                </div>
								<div>
                                                                        PASSWORD       	:       <input type="password" name="customer[password]" required/>
                                                                </div>
                                                                <input className="submit" type="submit" defaultValue="submit"/>
                                                        </form>
                                                </div>
					);
				break;
				default:
					Loginform   =       (
                        		        <div>
                        		                <div className="title">Sign up to browse products!</div>
                        		                <div className="fb-button">
                        		                        <div className="image">
                        		                                <img src="//main.cdn.wish.com/bc4736c509b1/img/login_modal/facebook.png?v=13"/>
                        		                        </div>
                        		                        <span className="text">Sign up with Facebook</span>
                        		                </div>
                        		                <div className="google-button">
                        		                        <div className="image">
                        		                                <img src="//main.cdn.wish.com/bc4736c509b1/img/login_modal/googleplus.png?v=13"/>
                        		                        </div>
                        		                        <span className="text">Sign up with Google</span>
                        		                </div>
                        		                <div className="signup-email" onClick={this.setRegisterForm}>Sign up with Email</div>
                        		                <div className="or"><hr/>or</div>
                        		                <div className="login-button" onClick={this.setLoginForm}>Login</div>
                        		        </div>
                        		);
				break;
			}




			var returnhtml 	= this.isshow?(
				<div className="modalboxcontainer" style={{ width:"100%",height:"100%","position":"fixed",left:0,top:0,right:0,bottom:0}}>
					<div className="modalbox" style={{ width:"100%",height:"100%",opacity:0.8,"z-index":100000,"position":"fixed",left:0,top:0,background:"#000"}}>
						
					</div>
					<div className="boxofmodal">
						<div className="formimage"><img src="//cdn.shopify.com/s/files/1/0964/9808/products/GP1810_2_1024x1024.jpg?v=1481593659"/></div>
						<div className="closebutton" onClick={this.closebox}> X </div>
						<div className="loginform">
							<div className="back" onClick={this.setFirstForm}><img src="//main.cdn.wish.com/bc4736c509b1/img/login_modal/back.png?v=13"/></div>
							{Loginform}
						</div>
	                                </div>
				</div>
			):(<div></div>);
			return returnhtml;
		}
	});
	var ModalNode			=		ReactDOM.render(React.createElement(Modal,null),document.getElementById("modalbox"));
	$("#customer_login_link").click(function(){
		ModalNode.isshow		=		true;
		ModalNode.forceUpdate();
	})
})

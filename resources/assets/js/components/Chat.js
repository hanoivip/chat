import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import ChatMessages from './ChatMessages'
import ChatForm from './ChatForm';


export default class Chat extends Component {
	constructor(props) {
	    super(props);
	    this.state = {
	    	error: null,
	    	isLoaded: false,
	    	messages: [],
	    	read: 0,
	    }
	}
	componentDidMount() 
	{
		const sender=this.props.other;
		const isLoaded=this.state.isLoaded;
		if (!isLoaded)
		{
			fetch("/api/chat/messages?access_token=" + API_TOKEN + "&sender=" + sender, {
		    	method: 'GET',
		    	headers: {
		    		'X-Requested-With': 'XMLHttpRequest',
		    	}
		    })
	      .then(res => res.json())
	      .then(
	        (result) => {
	          this.setState({
	            isLoaded: true,
	            messages: result.data.messages.reverse(),
	            read: result.data.read,
	          });
	          window.Echo.private('chat').listen('.test.chat', (e) => this.onNewMessage(e));
	        },
	        (error) => {
	          this.setState({
	            error: error
	          });
	        }
	      )
		}
		
	}
	onNewMessage(e)
	{
		console.log('new message arrival');
		let messages=this.state.messages;
		messages.push({sender_id: e.senderId, sender_name: e.senderName, message: e.message, created_at: 'now'});
		this.setState({messages: messages});
	}
	onSent(message)
	{
		console.log('message sent:', message);
		let messages=this.state.messages;
		console.log(messages);
		messages.push({sender_id: -1, sender_name: 'me', message: message, created_at: 'now'});
		this.setState({messages: messages});
	}
    render() {
    	const otherId = this.props.other;
    	const otherName = this.props.otherName;
    	//const count = this.props.count;
		const messages = this.state.messages;
    	const isLoaded = this.state.isLoaded;
		if (isLoaded)
		{
	        return (
        		<div className="container">
	        	    <div className="row">
	        	        <div className="col-md-5">
	        	            <div className="panel panel-primary">
	        	                <div className="panel-heading" id="accordion">
	        	                    <span className="glyphicon glyphicon-comment"></span> Chat with {otherName}
	        	                    <div className="btn-group pull-right">
	        	                        <a type="button" className="btn btn-default btn-xs" data-toggle="collapse" data-parent="#accordion" href={"#collapseOne" + otherId}>
	        	                            <span className="glyphicon glyphicon-chevron-down"></span>
	        	                        </a>
	        	                    </div>
	        	                </div>
		        	            <div className="panel-collapse collapse" id={"collapseOne" + otherId}>
			        	            <ChatMessages sender={otherId} messages={messages}/>
					    			<ChatForm receiver={otherId} onSent={(message) => this.onSent(message).bind(this) }/>
		        	            </div>
			        	     </div>
		        	    </div>
	    			</div>
	    		</div>
	        );
		}
		else
		{
			return (<div className="container">
	        	    	<div className="row">
		    				<img src="img/loading.gif"/>
	    				</div>
		    		</div>
		    		);
		}
    }
}

if (document.getElementById('my-chat')) {
	var element = document.getElementById('my-chat');
	var sender = element.getAttribute('other');
	var sname = element.getAttribute('other-name');
	var count=element.getAttribute('unread');
    ReactDOM.render(<Chat other={sender} otherName={sname} unread={count} />, document.getElementById('my-chat'));
}
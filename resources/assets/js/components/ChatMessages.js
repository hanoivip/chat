import React, { Component } from 'react'
import ReactDOM from 'react-dom'
export default class ChatMessages extends Component {
	constructor(props) {
	    super(props);
	}
    render() {
    	const messages = this.props.messages;
    	const sender = this.props.sender;
    	let list = [];
    	messages.forEach(function (message, index) {
    		list.push(<li key={index} className={message.sender_id==sender?"left clearfix":"right clearfix"}>
    					<span className={message.sender_id==sender?"chat-img pull-left":"chat-img pull-right"}>
							<img src="http://placehold.it/50/55C1E7/fff&text=U" alt="User Avatar" className="img-circle" />
						</span>
	                    <div className="chat-body clearfix">
	                        <div className="header">
	                            <strong className="primary-font">{message.sender_name}</strong> <small className="pull-right text-muted">
	                                <span className="glyphicon glyphicon-time"></span>{message.created_at}</small>
	                        </div>
	                        <p>
	                            {message.message}
	                        </p>
	                    </div>
	                </li>);
    	})
        return (
    		<div className="panel-body">
                <ul className="chat">
		        	{ list }
			    </ul>
            </div>
        );
    }
}
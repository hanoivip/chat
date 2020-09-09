import React, { Component } from 'react'
import ReactDOM from 'react-dom'
export default class ChatForm extends Component {
	constructor(props) {
	    super(props);
	    this.state = {
	    	isLoaded: false,
	    	message: '',
	    	error: null
	    }
	}
	sendMessage()
	{
		const receiver=this.props.receiver;
		const message=this.state.message;
		const data=new FormData();
		data.append('access_token', API_TOKEN);
		data.append('message', message);
		data.append('receiver', receiver);
		const uri="/api/chat/send";
		axios.post(uri, data)
		.then((result) => {
		  this.setState({
		    message: ''
		  });
		  this.props.onSent(message);
		})
		.catch((error) => {
			this.setState({
		        error: error
		      });
		});
	}
	markRead()
	{
		
	}
	render()
	{
		const message=this.state.message;
		return (<div className="panel-footer">
	                <div className="input-group">
	                    <input id="btn-input" type="text" className="form-control input-sm" placeholder="Type your message here..." 
	                    	value={this.state.message} onChange={(e) => this.setState({message: e.target.value}) } />
	                    <span className="input-group-btn">
	                        <button className="btn btn-warning btn-sm" id="btn-chat" onClick={this.sendMessage.bind(this)}>
	                            Send</button>
	                    </span>
	                </div>
	            </div>);
	}
}
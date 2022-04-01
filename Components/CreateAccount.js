
import { Formik, Field, Form } from 'formik';//imort av formik
import { useState } from 'react';

export default function CreateAccount() {

    const [username, setUsername] = useState("")
    const [password, setPassword] = useState("")

    const sendLogin = async () => {
        console.log(username, password)
        const response = await fetch("http://localhost/jann/slutprojekt/nextjs-setup/pages/Php/createAccount.php", {
            method: "POST",
            body: JSON.stringify({ username, password }),
            headers: {
                "Content-Type": "application/json"
            }
        })
        const data = await response.JSON
        console.log(data)
    }

    return (
        <Formik
            initialValues={{ //start value for form
                username: '',
                password: '',
            }}

            onSubmit={() => {
                
            }}//what happens when you press login
        >
            <Form>{/* login form */}
                <Field type="text" id="username" name="username" value={username} placeholder="Username" onChange={(e) => setUsername(e.target.value)}/>
                <Field type="password" id="password" name="password" value={password} placeholder="Password" onChange={(e) => setPassword(e.target.value)}/>
                <button type="submit" onClick={sendLogin}>Skapa</button>
            </Form>
        </Formik>
    )
}

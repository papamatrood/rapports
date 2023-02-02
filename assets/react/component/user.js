import React from "react";
import { RolesTable } from "../helpers/userHelpers";
import UserModal from "./userModal";
import { useDeleteUser } from "../hooks/userHooks";

const User = ({ user, setUsers, users }) => {
    const { errors, load, loading } = useDeleteUser(`http://localhost:8000/my_api/deleteUser/${user.id}`, 'DELETE')

    const handleDelete = (id) => {
        if (confirm("êtes vous sûr de cette action ?")) {
            load(user);
            const usersCopy = [...users];
            const usersCopyUpdated = usersCopy.filter(u => u.id !== id)
            setUsers(usersCopyUpdated)
        }
    }

    return (
        <tr>
            <td>{user.firstname}</td>
            <td>{user.lastname}</td>
            <td>{user.email}</td>
            <td>{RolesTable[user.roles]}</td>
            <td>
                <div className="btn-group" role="group">
                    {/* <a
                        className="btn btn-sm btn-primary d-inline"
                        href=""
                    >Modifier</a> */}
                    {<UserModal user={user} setUsers={setUsers} users={users} key={user.id} />}
                    <a className="btn btn-sm btn-danger d-inline" onClick={() => handleDelete(user.id)}>Supprimer</a>
                </div>


            </td>
        </tr>
    )
}

export default User;
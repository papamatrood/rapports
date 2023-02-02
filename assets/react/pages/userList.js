import React, { useEffect, useState } from "react";
import { useNavigate, useLocation } from "react-router-dom";
import AddUser from "../form/addUser";
import User from "../component/user";
import Graph from "../component/graph";
import Pagination from "../component/pagination";
import { useGetUsers } from "../hooks/userHooks";



const UserList = () => {
    const { users, load, loading, setUsers } = useGetUsers("http://localhost:8000/my_api/users");
    const [currentPage, setCurrentPage] = useState(1);
    const [perPage, setPerPage] = useState(7);

    const lastIndex = currentPage * perPage;
    const firstIndex = lastIndex - perPage;
    const currentUsers = users.slice(firstIndex, lastIndex);


    useEffect(() => {
        load()
    }, []);

    let location = useLocation();

    return (

        <div className="container-fluid">

            <div className="row">
                <div className="col-md-4 pt-3">
                    <Graph />
                </div>
                <div className="col-md-8">
                    <div className="table-responsive p-3">
                        <fieldset className="border p-2">
                            <legend>Les users d'activités</legend>
                            <table className="table table-sm table-bordered table-striped text-center mb-0">
                                <thead>
                                    <tr>
                                        <th width="10%">Prénom</th>
                                        <th width="10%">Nom</th>
                                        <th width="12%">Émail</th>
                                        <th width="10%">Rôle</th>
                                        <th width="15%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {users ? (
                                        currentUsers.map((user) => <User key={user.id} user={user} setUsers={setUsers} users={users} />)
                                    ) : (
                                        <tr>
                                            <td colspan="8">Aucun enregistrement trouvé</td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </fieldset>
                        {users && <Pagination
                            totalUsers={users.length}
                            perPage={perPage}
                            setCurrentPage={setCurrentPage}
                            currentPage={currentPage} />}
                        <AddUser setUsers={setUsers} users={users} />
                    </div>
                </div>
            </div>
        </div>
    )
}

export default UserList;
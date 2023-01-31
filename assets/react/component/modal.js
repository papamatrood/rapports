import React from "react";
import EditRapport from "../form/editRapport";

const Modal = ({ rapport }) => {

    let dataTarget = "#rapportModal" + rapport.id;
    let targetId = "rapportModal" + rapport.id;

    return (
        <div>

            <button type="button" className="btn btn-sm btn-primary d-inline" data-bs-toggle="modal" data-bs-target={dataTarget}>Modifier</button>

            <div className="modal fade" id={targetId} tabIndex="-1" aria-labelledby="rapportModalLabel" aria-hidden="true">
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h1 className="modal-title fs-5" id="rapportModalLabel">Modification de rapport</h1>
                            <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <EditRapport rapport={rapport} />
                    </div>
                </div>
            </div>

        </div>
    )
}

export default Modal;
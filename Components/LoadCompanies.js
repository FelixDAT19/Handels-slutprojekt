import React from "react";

function LoadCompanies({ name, companyInfo, externalUrl, logoUrl }) {
  return (
    <div>
      <img src={logoUrl} alt={logoUrl} />
      <h1>{name}</h1>
      <p>
        {companyInfo}
        <br />
        <a href={externalUrl}>{externalUrl}</a>
      </p>
    </div>
  );
}

export default LoadCompanies;

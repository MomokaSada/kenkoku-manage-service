<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>建国サーバー 2025 Winter - NPCシステムガイド</title>
  <style>
    /* CSS Variables & Reset */
    :root {
      --bg-color: #121212;
      --card-bg: #1e1e1e;
      --text-primary: #e0e0e0;
      --text-secondary: #a0a0a0;
      --accent-color: #4caf50;
      /* Minecraft Green-ish */
      --accent-hover: #45a049;
      --danger-color: #ff5252;
      --gold-color: #ffd700;
      --rare-color: #e91e63;
      --info-color: #2196f3;
      --font-family: 'Inter', 'Helvetica Neue', Arial, sans-serif;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: var(--bg-color);
      color: var(--text-primary);
      font-family: var(--font-family);
      line-height: 1.6;
      padding: 20px;
      background-image: radial-gradient(circle at 50% 50%, #1a1a1a 0%, #121212 100%);
      min-height: 100vh;
    }

    /* Typography */
    h1,
    h2,
    h3,
    h4 {
      color: #fff;
      margin-bottom: 1rem;
      font-weight: 700;
    }

    h1 {
      text-align: center;
      margin-bottom: 3rem;
      font-size: 2.5rem;
      text-transform: uppercase;
      letter-spacing: 2px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
      background: linear-gradient(45deg, #fff, #ccc);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    h2 {
      border-bottom: 2px solid var(--accent-color);
      padding-bottom: 0.5rem;
      display: inline-block;
      font-size: 1.5rem;
    }

    h3 {
      font-size: 1.2rem;
      color: var(--text-secondary);
      margin-top: 1.5rem;
      border-left: 3px solid var(--accent-color);
      padding-left: 10px;
    }

    h4 {
      font-size: 1rem;
      margin-bottom: 0.5rem;
    }

    /* Layout */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 25px;
    }

    .full-width {
      grid-column: 1 / -1;
    }

    /* Cards */
    .card {
      background-color: var(--card-bg);
      border-radius: 16px;
      padding: 25px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
      border-color: rgba(255, 255, 255, 0.1);
    }

    /* Specific Sections */
    .note {
      font-size: 0.9em;
      color: var(--text-secondary);
      margin-top: 10px;
      font-style: italic;
    }

    .info-box {
      padding: 15px;
      border-left: 4px solid var(--info-color);
      background: rgba(33, 150, 243, 0.1);
      margin-bottom: 15px;
      border-radius: 0 6px 6px 0;
    }

    .warning-box {
      padding: 15px;
      border-left: 4px solid var(--gold-color);
      background: rgba(255, 215, 0, 0.1);
      margin-bottom: 15px;
      border-radius: 0 6px 6px 0;
    }

    .step-list {
      list-style: none;
      counter-reset: step-counter;
      padding-left: 0;
    }

    .step-list li {
      counter-increment: step-counter;
      padding: 12px 15px 12px 50px;
      position: relative;
      margin-bottom: 10px;
      background: rgba(76, 175, 80, 0.05);
      border-radius: 6px;
      border-left: 3px solid var(--accent-color);
    }

    .step-list li::before {
      content: counter(step-counter);
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: var(--accent-color);
      color: #121212;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      font-size: 0.9em;
    }

    .item-list {
      list-style: none;
      padding-left: 0;
    }

    .item-list li {
      padding: 8px 0;
      border-bottom: 1px solid #333;
      display: flex;
      align-items: center;
    }

    .item-list li:last-child {
      border-bottom: none;
    }

    .item-list li::before {
      content: "◆";
      color: var(--accent-color);
      margin-right: 12px;
      font-size: 0.8em;
    }

    .npc-types {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 15px;
      margin-top: 15px;
    }

    .npc-type-card {
      background: rgba(255, 255, 255, 0.03);
      padding: 15px;
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .npc-type-card h4 {
      color: var(--accent-color);
      margin-bottom: 8px;
    }

    .code-block {
      background: #0d0d0d;
      border: 1px solid #333;
      border-radius: 6px;
      padding: 12px;
      font-family: 'Roboto Mono', monospace;
      font-size: 0.9em;
      color: var(--accent-color);
      margin: 10px 0;
      overflow-x: auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
      h1 {
        font-size: 1.8rem;
        margin-bottom: 2rem;
      }

      .container {
        grid-template-columns: 1fr;
      }

      .card {
        padding: 20px;
      }

      .npc-types {
        grid-template-columns: 1fr;
      }
    }
  </style>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=Roboto+Mono:wght@500&display=swap"
    rel="stylesheet">
</head>

<body>

  <h1>NPCシステムガイド</h1>

  <div class="container">

    <!-- NPCシステム概要 -->
    <div class="card full-width">
      <h2>🎮 NPCシステムとは？</h2>
      <div style="margin-top: 15px;">
        <p style="margin-bottom: 15px;">
          建国サーバーでは、様々な機能を持つ<strong>NPC（Non-Player Character）</strong>が存在します。
          NPCと取引をすることで、アイテムの売買やクエストの受注、特別なアイテムの入手などが可能です。
        </p>
        <div class="info-box">
          <strong>💡 NPCの特徴</strong><br>
          • NPCは攻撃できません（無敵状態）<br>
          • NPCは移動しません（固定位置）<br>
          • 右クリックで取引画面を開けます
        </div>
      </div>
    </div>

    <!-- NPC召喚エッグの使い方 -->
    <div class="card full-width">
      <h2>🥚 NPC召喚エッグの使い方</h2>
      <div style="margin-top: 15px;">
        <p style="margin-bottom: 15px;">
          <strong>NPC召喚エッグ</strong>を使用することで、指定のNPCをあなたの位置に召喚できます。
        </p>

        <h3>使用方法</h3>
        <ol class="step-list">
          <li>NPC召喚エッグを<strong>メインハンド</strong>または<strong>オフハンド</strong>に持つ</li>
          <li><strong>右クリック</strong>する</li>
          <li>あなたの足元にNPCが召喚されます</li>
          <li>エッグは消費されます（サバイバルモードのみ）</li>
        </ol>

        <div class="warning-box">
          <strong>⚠️ 注意事項</strong><br>
          • 召喚エッグは1回使用すると消費されます<br>
          • NPCは一度召喚すると移動できません<br>
          • 安全な場所で召喚してください
        </div>

        <h3>召喚エッグの入手方法</h3>
        <p style="margin-top: 10px;">NPC召喚エッグは、街を発展させることで入手できる<strong>NPC交換券</strong>を使用して、「NPC販売」NPCから購入できます。</p>
      </div>
    </div>

    <!-- NPCとの取引方法 -->
    <div class="card">
      <h2>💼 NPCとの取引方法</h2>
      <div style="margin-top: 15px;">
        <h3>基本的な取引の流れ</h3>
        <ol class="step-list">
          <li>NPCに近づいて<strong>右クリック</strong></li>
          <li>取引画面が開きます</li>
          <li>取引に必要なアイテムを確認</li>
          <li>クリックして取引を実行</li>
        </ol>

        <div class="info-box" style="margin-top: 15px;">
          <strong>💡 一括取引</strong><br>
          取引画面の右下にある<strong>金塊ボタン</strong>をクリックすることで、
          取引量を <strong>x1 → x16 → x32 → x48 → x64</strong> と切り替えることができます。<br>
          設定した個数分、連続して取引を行います。
        </div>
      </div>
    </div>

    <!-- クエストシステム -->
    <div class="card">
      <h2>📜 クエストシステム</h2>
      <div style="margin-top: 15px;">
        <h3>クエストの受け方</h3>
        <ol class="step-list">
          <li>クエストNPCを右クリック</li>
          <li>受けたいクエストを選択</li>
          <li>必要なアイテムを集める</li>
          <li>再度NPCに話しかけて納品</li>
          <li>報酬を受け取る</li>
        </ol>

        <div class="warning-box" style="margin-top: 15px;">
          <strong>⚠️ クエストの注意点</strong><br>
          • クエストは<strong>1回のみ完了可能</strong>です<br>
          • 一度完了したクエストは再度受けられません<br>
          • クエストの難易度は★の数で表されます
        </div>

        <h3>クエストの難易度</h3>
        <ul class="item-list" style="margin-top: 10px;">
          <li><strong>★ (初級)</strong> - 報酬: 福引券 ×10</li>
          <li><strong>★★ (中級)</strong> - 報酬: 福引券 ×20</li>
          <li><strong>★★★ (上級)</strong> - 報酬: 福引券 ×30</li>
          <li><strong>特別クエスト</strong> - 報酬: 専用アイテム</li>
        </ul>
      </div>
    </div>

    <!-- NPCの種類 -->
    <div class="card full-width">
      <h2>🏪 NPCの種類</h2>
      <div style="margin-top: 15px;">
        <div class="npc-types">
          <div class="npc-type-card">
            <h4>💰 買取屋</h4>
            <p style="font-size: 0.9em; color: var(--text-secondary);">
              アイテムを売却してお金を得ることができます。
              鉱石、農作物、水産物、レアアイテムなど、様々なアイテムを買い取ります。
            </p>
          </div>

          <div class="npc-type-card">
            <h4>🏪 雑貨屋</h4>
            <p style="font-size: 0.9em; color: var(--text-secondary);">
              シュルカーボックス、バンドル、額縁などの便利アイテムを購入できます。
              一部はチケットとの交換です。
            </p>
          </div>

          <div class="npc-type-card">
            <h4>⚔️ 武器・防具屋</h4>
            <p style="font-size: 0.9em; color: var(--text-secondary);">
              弓、矢、トライデント、メイスなどの武器を購入できます。
              武器チケットで特殊なエンチャント武器も入手可能。
            </p>
          </div>

          <div class="npc-type-card">
            <h4>📚 本屋</h4>
            <p style="font-size: 0.9em; color: var(--text-secondary);">
              エンチャント本を購入できます。
              耐久、鋭さ、幸運、効率強化などが揃っています。
            </p>
          </div>

          <div class="npc-type-card">
            <h4>🌊 海晶屋</h4>
            <p style="font-size: 0.9em; color: var(--text-secondary);">
              海晶ブロック、暗海晶ブロック、シーランタンを購入できます。
              建築に便利な海洋系ブロックが揃っています。
            </p>
          </div>

          <div class="npc-type-card">
            <h4>📜 クエスト</h4>
            <p style="font-size: 0.9em; color: var(--text-secondary);">
              様々なクエストを受注できます。
              難易度に応じて福引券や専用アイテムが報酬として得られます。
            </p>
          </div>

          <div class="npc-type-card">
            <h4>🎰 福引屋</h4>
            <p style="font-size: 0.9em; color: var(--text-secondary);">
              福引券を使ってガチャを引けます。
              アクセサリーやレアアイテムが当たるかも！
            </p>
          </div>

          <div class="npc-type-card">
            <h4>🍽️ お食事処</h4>
            <p style="font-size: 0.9em; color: var(--text-secondary);">
              お食事券を使って便利なバフを得られます。
              採掘速度、スピード、火炎耐性などのバフが用意されています。
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- よくある質問 -->
    <div class="card full-width">
      <h2>❓ よくある質問（FAQ）</h2>
      <div style="margin-top: 15px;">
        <h3>Q: NPCが反応しません</h3>
        <p style="margin-top: 5px; margin-bottom: 15px; color: var(--text-secondary);">
          A: NPCを<strong>右クリック</strong>してください。左クリックでは反応しません。
        </p>

        <h3>Q: 取引券が足りなくなりました</h3>
        <p style="margin-top: 5px; margin-bottom: 15px; color: var(--text-secondary);">
          A: 取引券は取引後に自動的に返却されます。インベントリに取引券がない場合、NPCを右クリックすると自動的に64枚付与されます。
        </p>

        <h3>Q: クエストを再度受けたいです</h3>
        <p style="margin-top: 5px; margin-bottom: 15px; color: var(--text-secondary);">
          A: クエストは<strong>1回のみ完了可能</strong>です。一度完了したクエストは再度受けることができません。
        </p>

        <h3>Q: NPCを移動させたいです</h3>
        <p style="margin-top: 5px; margin-bottom: 15px; color: var(--text-secondary);">
          A: NPCは一度召喚すると移動できません。召喚する前に、設置場所を慎重に選んでください。
        </p>

        <h3>Q: 召喚エッグはどこで入手できますか？</h3>
        <p style="margin-top: 5px; margin-bottom: 15px; color: var(--text-secondary);">
          A: 街を発展させて入手できる<strong>NPC交換券</strong>を使用し、「NPC販売」NPCから購入できます。
        </p>
      </div>
    </div>

  </div>

</body>

</html>
